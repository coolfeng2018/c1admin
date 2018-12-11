<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 数据模型 - 基类 TODO：所有自定义模型 都可以继承此基类
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{

    /**
     * 实例化单例模型
     * @return mixed
     */
    public static function loading()
    {
        return app()->make(get_called_class());
    }


    /**
     * updated_at 时间格式化
     * @param $value
     */
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * updated_at 时间格式化
     * @return false|string
     */
    public function getUpdatedAtAttribute($value)
    {
        return is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value ;
    }

    /**
     * updated_at 时间格式化
     * @param $value
     */
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * updated_at 时间格式化
     * @return false|string
     */
    public function getCreatedAtAttribute($value)
    {
        return is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value ;
    }
}
