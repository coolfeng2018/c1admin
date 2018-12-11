<?php

namespace App\Console\Commands;

use App\Models\DataTableFeeModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeUserTableFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:make_user_table_fee {--date=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每天生成前一天产生的台费信息';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        set_time_limit(0);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = $this->option('date');
        $date = empty($date) ? date('Y-m-d') : $date ;
        $sdate = strtotime($date);
        $edate = $sdate + 86400 ;

        $where = " is_robot=0 ";
        $where .= " AND reason IN(6,15)";
        $where .= " AND `time` >= {$sdate} AND `time` < {$edate}";

        $sql = "SELECT tablefee.time,SUM(tablefee.value) AS money,tablefee.game_type,tablefee.table_type FROM 
(SELECT FROM_UNIXTIME(`time`, '%Y%m%d') AS `time`,`value`,game_type,table_type FROM `user_money` WHERE {$where} ) AS tablefee
 GROUP BY tablefee.`time`,tablefee.game_type,tablefee.table_type";
        $data = DB::connection(config('constants.MYSQL_ONE_BY_ONE'))->select($sql);
        if($data){
            foreach ($data as $item) {
                $this->createTableFeeRecord($item);
            }
        }
        die('SUCCESS' . PHP_EOL);
    }

    /**
     * 生成数据
     * @param $item
     * @return bool
     */
    public function createTableFeeRecord($item)
    {
        $ret = false ;
        if($item){
            $model = DataTableFeeModel::query();
            $info = $model->where('date',$item->time)
                          ->where('game_type',$item->game_type)
                          ->where('table_type',$item->table_type)->first();
            $param = [
                'date'=>$item->time,
                'game_type'=>$item->game_type,
                'table_type'=>$item->table_type,
                'table_fee'=>$item->money, // 金钱以元为单位
            ];
            if($info){
                $ret = DataTableFeeModel::where('id',$info->id)
                    ->update($param);
            }else{
                $ret = DataTableFeeModel::create($param);
            }
        }
        return $ret;
    }
}
