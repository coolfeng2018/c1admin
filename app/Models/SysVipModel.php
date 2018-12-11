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
 * Class SysVipModel
 * @package App\Models
 */
class SysVipModel extends BaseModel
{
    protected $table = 'sys_vip';

    /**
     * 自动 写入
     * @var array
     */
    protected $fillable = ['level', 'week_award_max', 'icon_border_url', 'battery_url', 'charge_coins', 'privilege', 'online','enter_word','free_num','caishen_base_rate'];

    protected $appends = ['privilege_name'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * VIP特权
     * @var array
     */
    public static $privilege = [
        1 => "VIP头像框",
        2 => "VIP专属炮台",
        3 => "周福利领取上限",
        4 => "财神触发概率",
        5 => "每日大抽奖免费次数",
        6 => "入场动画",
        7 => "上线广播",
        8 => '互动礼物',
        9 => "美女1V1",
        10 => "提现加速"
    ];

    /**
     * @param $v
     * @return false|string
     */
    public function setPrivilegeAttribute($v)
    {
        $this->attributes['privilege'] = json_encode($v);
    }

    public function getPrivilegeAttribute($v)
    {
        return !empty($v) ? json_decode($v, true) : '';
    }

    /**
     * @param $v
     * @return mixed
     */
    public function getPrivilegeNameAttribute($v)
    {
        if ($this->privilege) {
            $str = '';
            foreach ($this->privilege as $k => $vv) {
                $str .= $k . ',' . self::$privilege[$vv] . ' ';
            }
            return $str;
        }
        return '';
    }


    public function getIconBorderUrlAttribute($value)
    {
        return config('server.file_upload_upload_url') . '/' . $value;
    }

    public function setIconBorderUrlAttribute($value)
    {
        if ($value) {
            $this->attributes['icon_border_url'] = str_replace(config('server.file_upload_upload_url') . '/', "", $value);
        }
        return $value;
    }

    public function getBatteryUrlAttribute($value)
    {
        return config('server.file_upload_upload_url') . '/' . $value;
    }

    public function setBatteryUrlAttribute($value)
    {
        if ($value) {
            $this->attributes['battery_url'] = str_replace(config('server.file_upload_upload_url') . '/', "", $value);
        }
        return $value;
    }

    /**
     * 取得中文名
     * @param $value
     * @return mixed|string
     */
//    public function getIsCirculAttribute($value)
//    {
//        return isset(self::$is_loop[$value]) ? self::$is_loop[$value] : '';
//    }

}