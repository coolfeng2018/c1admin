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
class TmpVersionListModel extends BaseModel
{
    protected $table      = 'version_listv2';
    protected $connection = 'mysql_one_by_one';


    public $timestamps = false;



    protected $appends = ['status_name'];

    protected static $status = [
        1 => '启用',
        2 => '禁用',
    ];


    /**
     * @param $value
     * @return mixed|string
     */
    public function getStatusNameAttribute($value)
    {
        return isset(self::$status[$this->status]) ? self::$status[$this->status] : '';
    }


}