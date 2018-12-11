<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 11:13
 * +------------------------------
 */

namespace App\Repositories;

use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Models\SysVipModel;
use Illuminate\Support\Facades\DB;

class VipRepository extends BaseRepository
{
    private static $vip_config = 'vip.lua';
    private static $vip_robot_config = 'robot_vip_control.lua';
    private static $vip_avatar_config = 'icon_border.lua';

    /**
     * 上传配置
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadVipConfig()
    {

        $result = DB::table('sys_vip')->select(['level', 'charge_coins', 'week_award_max', 'icon_border_url', 'battery_url', 'privilege', 'enter_word','free_num','caishen_base_rate'])->get();
        $result = $result->each(function ($item, $kk) {

            $temp_arr = json_decode($item->privilege, true);
            foreach ($temp_arr as $k => $v) {
                $temp_arr[$k] = SysVipModel::$privilege[$v];
            }
            $item->privilege = $temp_arr;

        })->toArray();

        $result = array_map('get_object_vars', $result);
        $params = json_encode([self::$vip_config => Covert::arrayToLuaStr($result)], JSON_UNESCAPED_UNICODE);

        return self::curl(config('server.upload_config_url'), $params);
    }

    /**
     * 上传VIP机器人配置
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadVipRobotConfig()
    {

        $result = DB::table('sys_vip_robot')->select(['min_coins', 'max_coins', 'vip_rate'])->get();

        $result = $result->each(function ($item, $k) {
            $item->vip_rate = json_decode($item->vip_rate, true);
            $item->coins = [1 => $item->min_coins, 2 => $item->max_coins];

            unset($item->min_coins);
            unset($item->max_coins);
        })->toArray();

        $result = array_map('get_object_vars', $result);

        $params = json_encode([self::$vip_robot_config => Covert::arrayToLuaStr($result)], JSON_UNESCAPED_UNICODE);

//        dump($params);
//        die ;

        return self::curl(config('server.upload_config_url'), $params);
    }

    /**
     * 上传机器人VIP 随机概率
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadRobotRankConfig()
    {

        $result = SysConfigModel::getSysKeyExists(SysConfigModel::ROBOT_RANK_VIP_KEY);

        $params = json_encode([SysConfigModel::ROBOT_RANK_VIP_KEY => Covert::arrayToLuaStr($result)], JSON_UNESCAPED_UNICODE);

//        dump($params);
//        die ;

        return self::curl(config('server.upload_config_url'), $params);
    }

    /**
     * 上传头像框配置
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadAvatarConfig()
    {
        $result = DB::table('sys_vip_avatar')->select(['avator_id', 'name', 'time_type', 'use_time', 'condition', 'icon_border_url'])->get();

        $result = $result->each(function ($item, $k) {
            $item->id = $item->avator_id;
            unset($item->avator_id);
        })->toArray();

        $result = array_map('get_object_vars', $result);

        $params = json_encode([self::$vip_avatar_config => Covert::arrayToLuaStr($result)], JSON_UNESCAPED_UNICODE);

//        dump($params);
//        die ;

        return self::curl(config('server.upload_config_url'), $params);
    }
}