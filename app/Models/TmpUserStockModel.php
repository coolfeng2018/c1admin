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
 * Class TmpUserStockModel
 * @package App\Models
 */
class TmpUserStockModel extends BaseModel
{

//   protected $fillable = ['weights', 'control_amount', 'creation_type', 'create_at', 'editor', 'curr_status'];
//
//    const UPDATED_AT = false;

    protected $table      = 'user_stock';
    protected $connection = 'mysql_one_by_one';

    public $timestamps = false;

}