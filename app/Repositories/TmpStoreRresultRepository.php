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
use App\Models\TmpStoreResultModel;

/**
 * 库存日志
 * Class SysConfigRepository
 * @package App\Repositories
 */
class TmpStoreRresultRepository extends BaseRepository
{
    public static $prefix = 'pre_';

    /**
     * 获取台费信息
     * @param $sdate 开始时间
     * @param $edate 结束时间
     * @return array
     */
    public static function getTableFeeList($sdate,$edate){
        $model = TmpStoreResultModel::query();
        if ($sdate){
            $model->where('today','>=',$sdate);
        }
        if($edate){
            $model->where('today','<=',$edate);
        }
        $data  =  $model->groupBy(['today','robot_type'])->get([
            'today',
            'modified_time',
            'robot_type',
            'fee_store',
            'award_store',
            'base_store'
        ])->toArray();
        $list = [] ;
        if($data){
            $tableListArr = config('game.robot_type_list');
            foreach ($data as $item) {
                if(isset($tableListArr[$item['robot_type']])){
                    $lastTime =  date('Y-m-d',$item['modified_time']-86400);
                    $lastRecord = TmpStoreResultModel::query()->where('robot_type',$item['robot_type'])->where('today',$lastTime)->first(['base_store','award_store','fee_store']);
                    $rtn = 0;
                    if($lastRecord){
                        $baseChange =  $item['base_store'] - $lastRecord['base_store'];
                        $awardChange =  $item['award_store'] - $lastRecord['award_store'];
                        $feeChange =  $item['fee_store'] - $lastRecord['fee_store'];
                        $rtn = $awardChange + $baseChange + $feeChange;
                    }
                    $list[$item['today']][self::$prefix.$item['robot_type']] = round($rtn/100,2);
                }
            }
            if($list){
                foreach ($tableListArr as $key=>$value) {
                    foreach ($list as $t=>$val) {
                        $list[$t]['today'] = $t ;
                        $tmp = isset($list[$t][self::$prefix.$key]) ? round($list[$t][self::$prefix.$key],2) : 0 ;
                        $list[$t][self::$prefix.$key] = $tmp ;
                        if(isset($list[$t]['totle'])){
                            $list[$t]['totle'] += round($tmp,2);
                        }else{
                            $list[$t]['totle'] = round($tmp,2);
                        }
                    }
                }
            }
        }
        return $list;
    }
}