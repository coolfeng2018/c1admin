<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/20 20:15
 * +------------------------------
 */

namespace App\Models;
use Illuminate\Support\Facades\DB;

/**
 * log
 * Class OrderModel
 * @package App\Models
 */
class TmpGameLogModel extends BaseModel
{
    /**
     * @param $table_type
     * @param $uid
     * @param $limit
     * @param $sTime
     * @param $eTime
     * @return mixed
     */
    public function getListData($table_type,$uid,$limit,$sTime,$eTime){
        $connectDatabase = config('constants.MYSQL_DATA_CENTER');
        $table = 'dc_log_game.gamemin'.date('Ym', $eTime);
        $model  = DB::connection($connectDatabase)->table($table);
        if (!empty($uid)){
            $model->where('true_user','like',"%{$uid}%");
        }
        if ($table_type != -1) {
            $model->where('table_type',$table_type);
        }
        $model->whereBetween('begin_time',[$sTime,$eTime]);
        $model   ->orderBy('begin_time', 'desc');
        $data = $model->paginate($limit);
        return json_decode(json_encode($data), true);
    }


    /**
     * @param $tableGid
     * @param $stime
     * @return mixed
     */
    public function getDetailData($tableGid,$stime){
        $table = 'dc_log_game.game'.date('Ym', strtotime($stime));
        $connectDatabase = config('constants.MYSQL_DATA_CENTER');
        $Model = DB::connection($connectDatabase)->table($table);
        $rest = $Model->where('table_gid',$tableGid)->get();
        return json_decode(json_encode($rest), true);
    }




}