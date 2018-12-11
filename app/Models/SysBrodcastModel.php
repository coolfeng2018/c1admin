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


use Illuminate\Database\Eloquent\Model;

class SysBrodcastModel extends Model
{
    protected $table = 'sys_broadcast';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['mid', 'type', 'broad_name', 'info', 'exit_time', 'coins_range_min', 'coins_range_max', 'time_range_min', 'time_range_max', 'target_coins', 'interval', 'is_need_fake'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 追加字段
     * @var array
     */
    protected $appends = ['coins_range', 'time_range', 'type_name'];

    public static $type = [
        1 => '周福利兑换广播',
        2 => '对局广播',
        3 => '大抽奖广播',
        4 => 'VIP上线广播'
    ];

    /**
     * 是否需要生成假数据
     * @var array
     */
    public static $is_need_fake = [
        0 => '否',
        1 => '是'
    ];

    /**
     * 取得中文名
     * @param $value
     * @return mixed|string
     */
    public function getTypeNameAttribute($value)
    {
        return isset(self::$type[$this->attributes['type']]) ? self::$type[$this->attributes['type']] : '未知';
    }

    /**
     * 取得[]
     * @param $value
     * @return false|string
     */
    public function getCoinsRangeAttribute($value)
    {
        return json_encode([$this->coins_range_min, $this->coins_range_max]);
    }

    /**
     * 取得json
     * @param $value
     * @return false|string
     */
    public function getTimeRangeAttribute($value)
    {
        return json_encode([$this->time_range_min, $this->time_range_max]);
    }


    /**
     * html实体化
     * @param $value
     * @return string
     */
    public function getInfoAttribute($value)
    {
        return htmlentities($value);
    }
}