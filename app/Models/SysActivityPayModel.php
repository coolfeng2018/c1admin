<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/9/19 11:14
 * +------------------------------
 */

namespace App\Models;
use Illuminate\Support\Facades\Log;

class SysActivityPayModel extends BaseModel
{
    protected $table = 'sys_activity_pay';

    protected $fillable = ['act_name', 'act_key', 'status', 'act_mark', 'act_point', 'act_info', 'start_time', 'end_time', 'auth', 'updated_at'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = true;
    //#此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';
    //追加非表中属性
    protected $appends = ['status_str'];

    /**
     * 状态 map
     * @var array
     */
    public static $statusArr = [
        0 => '待上线',
        1 => '生效中'
    ];


    /**
     * 取得图片
     * @return mixed|string
     */
    public function getActMarkAttribute()
    {
        $actMark = isset($this->attributes['act_mark']) ? $this->attributes['act_mark'] : '' ;
        return  config('server.file_upload_upload_url').'/'.$actMark;
    }
    /**
     * 设置图片
     * @return mixed|string
     */
    public function setActMarkAttribute($value)
    {
        if($value){
            $this->attributes['act_mark'] = str_replace(config('server.file_upload_upload_url').'/',"",$value);
        }
        return $value;
    }
    /**
     * 取得额外配置信息
     * @param $value
     * @return array|mixed
     */
    public function getActInfoAttribute($value)
    {
        if($value){
            $value  = $this->attributes['act_info'] = is_array($value) ? (array)$value:json_decode($value,true);
        }
        return $value;
    }

    /**
     * 设置额外配置信息
     * @param $value
     * @return string
     */
    public function setActInfoAttribute($value)
    {
        if($value){
            $this->attributes['act_info'] = is_array($value) ? json_encode($value,JSON_UNESCAPED_UNICODE) : $value ;
        }
        return $value;
    }


    /**
     * 取得状态中文名
     * @return mixed|string
     */
    public function getStatusStrAttribute()
    {
        $status = isset($this->attributes['status']) ? $this->attributes['status'] : '' ;
        return isset(self::$statusArr[$status]) ? self::$statusArr[$status] : '';
    }

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
        return is_numeric($value) ?  date('Y-m-d H:i:s', $value) : $value ;
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
     * end_time 时间格式化
     * @return false|string
     */
    public function getEndTimeAttribute($value)
    {
        return is_numeric($value) ?  date('Y-m-d H:i:s', $value) : $value ;
    }
}