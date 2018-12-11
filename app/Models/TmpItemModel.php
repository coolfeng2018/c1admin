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
 * Class TmpItemModel
 * @package App\Models
 */
class TmpItemModel extends BaseModel
{
    protected $table      = 'item';
    protected $connection = 'mysql_one_by_one';


}