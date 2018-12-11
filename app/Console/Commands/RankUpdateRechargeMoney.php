<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RankUpdateRechargeMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rank:update_recharge_money {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '根据每日排行榜更新用户每日充值总金额';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $date = $this->option('date');

        set_time_limit(0);
        $db = DB::table('data_rank_board');

        if (!empty($date)) {
            $db->whereBetween('created_at', [strtotime($date), (strtotime($date) + 86400)]);
        } else {
            $db->whereBetween('created_at', [strtotime('-1 day', $date), (strtotime('-1 day', $date) + 86400)]);
        }

        $data = $db->select(['id', 'uid', 'created_at'])->orderBy('created_at', 'DESC')->get()->toArray();

        if ($data) {
            $data = array_map('get_object_vars', $data);
            $this->getDayRechargeMoney($data);
        }

        die('SUCCESS' . PHP_EOL);
    }

    /**
     * 取得昨天累计充值金额
     * @param array $data
     * @param $db
     * @return array|bool
     */
    public function getDayRechargeMoney($data = [])
    {
        $connection = DB::connection(config('constants.MYSQL_PAYMENT'));

        $db = DB::table('data_rank_board');

        foreach ($data as $k => $v) {
            $recharge_money = $connection->table('order')
                ->whereBetween('create_time', [strtotime(date('Y-m-d', $v['created_at'])), (strtotime(date('Y-m-d', $v['created_at'])) + 86400)])
                ->where(['uid' => $v['uid'], 'status' => 2])
                ->sum('amount');

            echo $v['uid'] . '-' . $recharge_money . PHP_EOL;

            if ($recharge_money > 0) {
                $flag = $db->where(['uid' => $v['uid']])->update(['recharge_money' => $recharge_money / 100]);
                echo $flag . PHP_EOL;
            }
        }

        return true;
    }
}
