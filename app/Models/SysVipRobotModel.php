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

/**
 *
 * Class SysVipRobotModel
 * @package App\Models
 */
class SysVipRobotModel extends BaseModel
{
    protected $table = 'sys_vip_robot';

    /**
     * 自动 写入
     * @var array
     */
    protected $fillable = ['min_coins', 'max_coins', 'vip_rate'];

    protected $appends = ['coins', 'vip_rate_list'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 循环
     * @var array
     */
//    public static $is_loop = [
//        1 => '是',
//        0 => '否'
//    ];

    /**
     * VIP 概率
     * @var array
     */
    public static $vip_rate = [
        'vip_0' => 0,
        'vip_1' => 0,
        'vip_2' => 0,
        'vip_3' => 0,
        'vip_4' => 0,
        'vip_5' => 0,
        'vip_6' => 0,
    ];

    /**
     *
     * @param $v
     */
    public function setVipRateAttribute($v)
    {
        $this->attributes['vip_rate'] = json_encode($v);
    }

    /**
     *
     * @param $v
     * @return mixed
     */
    public function getVipRateAttribute($v)
    {
        $rate = json_decode($v, true);
        return is_array($rate) ? $rate : '';
    }

    /**
     *
     * @param $v
     * @return mixed
     */
    public function getVipRateListAttribute($v)
    {
        $vip_rate = '';
        foreach ($this->vip_rate as $k => $v) {
            $vip_rate .=  $k . '=' . $v . ' ';
        }
        return $vip_rate;
    }

    /**
     * 取得中文名
     * @param $value
     * @return mixed|string
     */
    public function getCoinsAttribute($value)
    {
        return $this->min_coins . '-' . $this->max_coins;
    }

}