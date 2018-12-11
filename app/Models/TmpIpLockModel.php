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
 * Class TmpDcusersModel
 * @package App\Models
 */
class TmpIpLockModel extends BaseModel
{
    protected $table      = 'ip_lock';
    protected $connection = 'mysql_one_by_one';

    public $timestamps = false;

    protected $appends = ['status','otime'];

    protected static $status = [
        1 => '封号',
        0 => '解禁',
    ];

    public function getStatusAttribute($value)
    {
        return self::$status[$this->attributes['lock_status'] ?? 0];
    }



    public function getOtimeAttribute($value)
    {
        $value = $this->attributes['op_time'] ?? '';
        return  $value ? date('Y-m-d H:i:s'):'';
    }

}