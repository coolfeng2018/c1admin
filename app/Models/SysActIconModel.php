<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/9/19 11:14
 * +------------------------------
 */

namespace App\Models;
/**
 * 活动ICON排序表
 * Class SysActivityListModel
 * @package App\Models
 */
class SysActIconModel extends BaseModel
{
    protected $table = 'sys_act_icon';

    protected $fillable = ['sort_id','key_id', 'name_id', 'auth'];

    protected $appends = ['name'];
    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;


    public static $name = [
        9 => '周福利',
        10 => '大抽奖',
        11 => '代理',
        12 => '客服',
        13 => 'VIP',
    ];
    public function getNameAttribute()
    {
        $value = isset($this->attributes['name_id']) ? $this->attributes['name_id'] : '' ;
        return isset(self::$name[$value]) ? self::$name[$value] : '';
    }
}