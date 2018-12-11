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
 * 流水数据临时表
 * Class OrderModel
 * @package App\Models
 */
class TmpUserMoneyModel extends BaseModel
{
    protected $table      = 'user_money';
    protected $connection = 'mysql_one_by_one';

//    public $timestamps = false;

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


}