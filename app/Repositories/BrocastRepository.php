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
use Illuminate\Support\Facades\DB;

/**
 * 系统配置
 * Class BrocastRepository
 * @package App\Repositories
 */
class BrocastRepository extends BaseRepository
{
    private static $config_filename = 'horse_message.lua';

    /**
     * 上传配置服务端
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadConfig()
    {
        $result = DB::table('sys_broadcast')->select(['mid', 'type', 'broad_name', 'info', 'exit_time', 'coins_range_min', 'coins_range_max', 'time_range_min', 'time_range_max', 'target_coins', 'interval', 'is_need_fake'])->get();

        $result = $result->each(function ($item, $k) {
//            if ($item->is_circul == 1) {
////                $item->play_start_time = date('H::i:s', strtotime($item->play_start_time));
////                $item->play_end_time = date('H::i:s', strtotime($item->play_end_time));
////            }
///
            $item->coins_range = [$item->coins_range_min, $item->coins_range_max];
            $item->time_range = [$item->time_range_min, $item->time_range_max];

            unset($item->coins_range_min);
            unset($item->coins_range_max);
            unset($item->time_range_min);
            unset($item->coins_range_min);
            unset($item->time_range_max);

        })->toArray();

        $result = array_map('get_object_vars', $result);
        $result = array_column($result, null, 'mid');

        $params = json_encode([self::$config_filename => Covert::arrayToLuaStr($result)], JSON_UNESCAPED_UNICODE);

//        dump($params);
//        die ;


        return self::curl(config('server.upload_config_url'), $params);
    }

}