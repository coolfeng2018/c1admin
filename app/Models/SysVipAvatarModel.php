<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 11:14
 * +------------------------------
 */

namespace App\Models;


/**
 *
 * Class SysVipAvatarModel
 * @package App\Models
 */
class SysVipAvatarModel extends BaseModel
{
    protected $table = 'sys_vip_avatar';

    /**
     * 自动 写入
     * @var array
     */
    protected $fillable = [
        'avator_id',
        'name',
        'time_type',
        'use_time',
        'condition',
        'icon_border_url',
        'online',
        'is_top',
        'sort'
    ];

    protected $appends = ['time_type_name'];


    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 循环
     * @var array
     */
    public static $time_type = [
        1 => '永久',
        2 => '实时'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getIconBorderUrlAttribute($value)
    {
        return config('server.file_upload_upload_url') . '/' . $value;
    }

    public function setIconBorderUrlAttribute($value)
    {
        if($value){
            $this->attributes['icon_border_url'] = str_replace(config('server.file_upload_upload_url').'/',"",$value);
        }
        return $value;
    }

    /**
     *
     * @param $value
     * @return mixed|string
     */
    public function getTimeTypeNameAttribute($value)
    {
        return isset(self::$time_type[$this->time_type]) ? self::$time_type[$this->time_type] : '';
    }

}