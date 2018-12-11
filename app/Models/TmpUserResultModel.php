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
 * user_result
 * Class OrderModel
 * @package App\Models
 */
class TmpUserResultModel extends BaseModel
{
    protected $table      = 'user_result';
    protected $connection = 'mysql_data_center';


    /**
     * time 时间格式化
     * @param $value
     */
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['time'] = is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * time 时间格式化
     * @return false|string
     */
    public function getTimeAttribute($value)
    {
        return is_numeric($value) ? date('Ymd', $value) : $value ;
    }

}