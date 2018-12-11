<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/25 10:44
 * +------------------------------
 */

namespace App\Models;

class UserMoneyUpdateModel extends BaseModel
{

    protected $table = 'user_money_update' ;

    protected $fillable = ['uid', 'type', 'value' ,'remarks', 'auth'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = true;
    //#此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';

    /**
     * 修改类型
     * @var array
     */
    public static $typeTrr = [
        1 => '加金币',
        2 => '减金币'
    ];

    /**
     * @return mixed|string
     */
    public function getTypeAttribute()
    {
        $value = isset($this->attributes['type']) ? $this->attributes['type'] : '' ;
        return isset(self::$typeTrr[$value]) ? self::$typeTrr[$value] : '';
    }

}