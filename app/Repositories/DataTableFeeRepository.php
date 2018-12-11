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
use App\Models\DataTableFeeModel;
use Illuminate\Support\Facades\DB;

/**
 * 台费日志
 * Class SysConfigRepository
 * @package App\Repositories
 */
class DataTableFeeRepository extends BaseRepository
{
    public static $prefix = 'pre_';

    /**
     * 获取台费信息
     * @param $sdate
     * @param $edate
     * @return array
     */
    public static function getTableFeeList($sdate,$edate){
        $model = DataTableFeeModel::query();
        if ($sdate){
            $model->where('date','>=',date('Ymd',strtotime($sdate)));
        }
        if($edate){
            $model->where('date','<=',date('Ymd',strtotime($edate)));
        }
        $data  =  $model->groupBy(['date','table_type'])->get(['date','table_type',DB::raw('sum(table_fee) as table_fee')])->toArray();
        $list = [] ;
        if($data){
            $tableListArr = config('game.table_list');
            foreach ($data as $item) {
                if(isset($tableListArr[$item['table_type']])){
                    $list[$item['date']][self::$prefix.$item['table_type']] = $item['table_fee'];
                }
            }
            if($list){
                foreach ($tableListArr as $key=>$value) {
                    foreach ($list as $t=>$val) {
                        $list[$t]['date'] = $t ;
                        $tmp = isset($list[$t][self::$prefix.$key]) ? round($list[$t][self::$prefix.$key]/100,2) : 0 ;
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