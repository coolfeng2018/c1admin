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
 * 用户数据获取
 * Class OrderModel
 * @package App\Models
 */
class TmpDcusersModel extends BaseModel
{
    protected $table      = 'dcusers';
    protected $connection = 'mysql_one_by_one';


}