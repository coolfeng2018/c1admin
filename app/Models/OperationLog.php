<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/11/12 11:12
 * +------------------------------
 */

namespace App\Models;


class OperationLog extends BaseModel
{
    protected $table = 'log_operate';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['user_id', 'user_name', 'method', 'path', 'params', 'ip','created_at','updated_at'];

    /**
     * 追加非表中属性
     * @var array
     */
    protected $appends = ['params_str'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';


    /**
     * 取得状态类型中文名
     * @return mixed|string
     */
    public function getParamsStrAttribute()
    {
        $value = isset($this->attributes['params']) ? json_decode($this->attributes['params'],true) : [] ;
        return $value;
    }
    /**
     * 取得状态类型中文名
     * @return mixed|string
     */
    public function setParamsAttribute($value)
    {
        $this->attributes['params'] = is_array($value) ? json_encode($value,JSON_UNESCAPED_UNICODE) : '' ;
        return $this->attributes['params'];
    }
}