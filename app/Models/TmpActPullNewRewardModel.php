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
 * 拉新活动-抽奖临时表
 * Class TmpActPullNewPumpModel
 * @package App\Models
 */
class TmpActPullNewRewardModel extends BaseModel
{
    protected $table      = 'dc_log_realtime.act_pullnew_reward';
    protected $connection = 'mysql_data_center';

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;

    /**
     * time 时间格式化
     * @param $value
     * @return false|string
     */
    public function getTimeAttribute($value)
    {
        return is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value ;
    }

    /**
     * award_list 时间格式化
     * @param $value
     * @return false|string
     */
    public function getAwardListAttribute($value)
    {
        return is_string($value) ? json_decode($value,true) : $value ;
    }
}