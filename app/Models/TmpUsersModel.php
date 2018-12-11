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

class TmpUsersModel extends BaseModel
{
    protected $table      = 'dc_log_user.users';
    protected $connection = 'mysql_data_center';

    //public $timestamps = false;


}