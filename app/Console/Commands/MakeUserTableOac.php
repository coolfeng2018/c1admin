<?php

namespace App\Console\Commands;

use App\Models\DataTableOacModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeUserTableOac extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:make_user_table_oac {--date=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每天生成前一天的产出与消耗';

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

        $configOac = config('game.oac_list');//获取reason_list
        unset($configOac['pay_fee']);
        unset($configOac['stock_totle']);
        unset($configOac['gold_surplus']);
        foreach ($configOac as $k => $v){
            $dataConfig[] = $k;
        }
        $configOac = implode(',',$dataConfig);//获取条件reason

        $where = " is_robot=0 ";
        $where .= " AND reason in( {$configOac} )";
        $where .= " AND `time` >= {$sdate} AND `time` < {$edate}";

        $sql = "SELECT tablefee.time,SUM(tablefee.value) AS money,tablefee.reason FROM 
(SELECT FROM_UNIXTIME(`time`, '%Y%m%d') AS `time`,`value`,reason FROM `user_money` WHERE {$where} ) AS tablefee
 GROUP BY tablefee.`time`,tablefee.reason";
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
            $model = DataTableOacModel::query();
            $info = $model->where('date',$item->time)
                ->where('reason',$item->reason)->first();
            $param = [
                'date'=>$item->time,
                'reason'=>$item->reason,
                'table_money'=>$item->money, // 金钱以元为单位
            ];
            if($info){
                $ret = DataTableOacModel::where('id',$info->id)
                    ->update($param);
            }else{
                $ret = DataTableOacModel::create($param);
            }
        }
        return $ret;
    }
}
