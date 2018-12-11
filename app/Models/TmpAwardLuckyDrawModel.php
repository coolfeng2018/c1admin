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

class TmpAwardLuckyDrawModel extends BaseModel
{
    protected $table      = 'dc_log_realtime.award_lucky_draw';
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
        return is_numeric($value) ? date('Y-m-d', $value) : $value ;
    }
}