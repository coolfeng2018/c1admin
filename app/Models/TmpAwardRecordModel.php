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

class TmpAwardRecordModel extends BaseModel
{
    protected $table      = 'dc_log_realtime.award_record';
    protected $connection = 'mysql_data_center';

    protected $fillable = ['key', 'cur_index', 'player_award_list', 'end_time', 'time', 'op'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;
    //追加非表中属性
    //protected $appends = ['end_time_str'];

    /**
     * time 时间格式化
     * @param $value
     * @return false|string
     */
    /*public function getEndTimeStrAttribute()
    {
        $value = isset($this->attributes['end_time']) ? $this->attributes['end_time'] : '' ;
        return is_numeric($value) ? date('Ymd', $value) : $value ;
    }*/
}