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
class TmpUserLockModel extends BaseModel
{
    protected $table      = 'user_lock';
    protected $connection = 'mysql_one_by_one';

    public $timestamps = false;

    protected $appends = ['status','etime','otime'];

    protected static $status = [
        1 => '封号',
        0 => '正常',
    ];

    public function getStatusAttribute($value)
    {
        return self::$status[$this->attributes['lock_status'] ?? 0];
    }

    public function getEtimeAttribute($value)
    {
        $value = $this->attributes['endtime'] ?? '';
        return  $value ? date('Y-m-d H:i:s'):'';
    }

    public function getOtimeAttribute($value)
    {
        $value = $this->attributes['op_time'] ?? '';
        return  $value ? date('Y-m-d H:i:s'):'';
    }

}