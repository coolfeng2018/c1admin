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
 * 消息
 * Class TmpMessageModel
 * @package App\Models
 */
class TmpCustomerModel extends BaseModel
{
    protected $table      = 'customer';
    protected $connection = 'mysql_one_by_one';
    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['CustomerId','uid','time'];
}