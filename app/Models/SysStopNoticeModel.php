<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 11:14
 * +------------------------------
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SysStopNoticeModel extends Model
{
    protected $table = 'sys_stop_notice';

    /**
     * 自动 写入
     * @var array
     */
    protected $fillable = ['title', 'info', 'inscribe', 'notice_time', 'start_time', 'end_time', 'redactor'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * start_time 时间格式化
     * @param $value
     */
    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * start_time 时间格式化
     * @return false|string
     */
    public function getStartTimeAttribute($value)
    {
        return is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value ;
    }

    /**
     * end_time 时间格式化
     * @param $value
     */
    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * start_time 时间格式化
     * @return false|string
     */
    public function getEndTimeAttribute($value)
    {
        return is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value ;
    }

}