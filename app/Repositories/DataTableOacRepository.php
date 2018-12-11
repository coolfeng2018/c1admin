<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/9/20 19:52
 * +------------------------------
 */

namespace App\Repositories;
use App\Models\DataTableOacModel;
use Illuminate\Support\Facades\DB;

/**
 * 产出与消耗
 * Class SysConfigRepository
 * @package App\Repositories
 */
class DataTableOacRepository extends BaseRepository
{
    public static $prefix = 'pre_';
    public static $payFee = 'pay_fee';//台费

    /**
     * 获取台费信息
     * @param $sdate
     * @param $edate
     * @return array
     */
    public static function getTableOacList($sdate,$edate){
        $model = DataTableOacModel::query();
        if ($sdate){
            $model->where('date','>=',date('Ymd',strtotime($sdate)));
        }
        if($edate){
            $model->where('date','<=',date('Ymd',strtotime($edate)));
        }
        $data  =  $model->groupBy(['date','reason'])->get(['date','reason',DB::raw('sum(table_money) as table_money')])->toArray();
        $list = [] ;
        if($data){
            $oacListArr = config('game.oac_list');
            foreach ($data as $item) {
                if(isset($oacListArr[$item['reason']])){
                    $list[$item['date']][self::$prefix.$item['reason']] = $item['table_money'];
                    //6 15 reason需要合并为pay_fee
                    if($item['reason']==6 || $item['reason']==15){
                        $list[$item['date']][self::$prefix.self::$payFee] = isset($list[$item['date']][self::$prefix.self::$payFee]) ? round($list[$item['date']][self::$prefix.self::$payFee]+$item['table_money'],2) : round($item['table_money'],2);
                    }
                }
            }
            if($list){
                foreach ($oacListArr as $key=>$value) {
                    foreach ($list as $t=>$val) {
                        $list[$t]['date'] = $t ;
                        $tmp = isset($list[$t][self::$prefix.$key]) ? round($list[$t][self::$prefix.$key]/100,2) : 0 ;
                        $list[$t][self::$prefix.$key] = $tmp ;
                        //库存收入
                        $sdate = date('Y-m-d',strtotime($t));
                        $edate = date('Y-m-d',strtotime($t)+86400);
                        $feeList = TmpStoreRresultRepository::getTableFeeList($sdate,$edate);
                        $list[$t][self::$prefix.'stock_totle'] = isset($feeList[$sdate]['totle']) ? $feeList[$sdate]['totle'] : 0;
                    }
                }
            }
        }
        //计算金币存量
        if(count($list)>0){
            foreach ($list as $k => $v){
                if(isset($v['pre_gold_surplus'])){
                    $list[$k]['pre_gold_surplus'] = round($v[self::$prefix.'100001']+$v[self::$prefix.'100028']+$v[self::$prefix.'100049']-$v[self::$prefix.'100040']-$v[self::$prefix.self::$payFee]-$v[self::$prefix.'stock_totle'],2);
                }
            }
        }
        return $list;
    }
}