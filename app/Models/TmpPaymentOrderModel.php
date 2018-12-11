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

/**
 * order
 * Class OrderModel
 * @package App\Models
 */
class TmpPaymentOrderModel extends BaseModel
{
    protected $table      = 'order';
    protected $connection = 'mysql2';

    public static $status = [
        'is_status' => 0,//已下单
        'is_no_status_finished' => 1,//已支付未处理
        'is_status_finished' => 2,//已支付已处理完成
    ];

    public  static $is_status = [

    ];


    /**
     * time 时间格式化
     * @param $value
     */
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['time'] = is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * create_time 时间格式化
     * @return false|string
     */
    public function getCreateTimeAttribute($value)
    {
        return is_numeric($value) ? date('Ymd', $value) : $value ;
    }

    /**
     * 获取新增用户充值数
     * @param array $uids
     * @return int
     */
    public function getNewRechargeUserCount($uids=[]){
        if(!$uids) return 0;
        $count = $this->distinct('uid')->whereIn('uid',$uids)->where('status',self::$status['is_status_finished'])->count('uid');
        return $count;
    }

    /**
     * 新增用户充值总额
     * @param array $uids
     * @return int
     */
    public function getNewUserRechargeSum($uids=[]){
        if(!$uids) return 0;
        $count = $this->whereIn('uid',$uids)->where('status',self::$status['is_status_finished'])->sum('amount');
        return $count;
    }

    /**
     * 总充值人数
     * @param int $time
     * @return mixed
     */
    public function getUserRechargeSum($time=0){
        $query = $this->distinct('uid')
            ->where('status',self::$status['is_status_finished']);
        if($time){
            $query = $query->where('create_time','<=',$time);
            $query = $query->where('create_time','>=',$time-86400);
        }
        $count = $query->count('uid');
        return $count;
    }

}