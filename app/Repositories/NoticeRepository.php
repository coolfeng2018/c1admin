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

class NoticeRepository extends BaseRepository
{

    private static $config_filename = 'system_notice.lua';

    /**
     * 上传配置
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadConfig()
    {

        $result = DB::table('sys_notice')->select(['id', 'info', 'interval', 'is_circul', 'play_start_time', 'play_end_time'])->get();

        $result = $result->each(function ($item, $k) {

            if ($item->is_circul == 1) {
                $item->play_start_time = date('H:i:s', strtotime($item->play_start_time));
                $item->play_end_time = date('H:i:s', strtotime($item->play_end_time));
            }

        })->toArray();

        $result = array_map('get_object_vars', $result);
        $result = array_column($result, NULL, 'id');

        $params = json_encode([self::$config_filename => Covert::arrayToLuaStr($result)], JSON_UNESCAPED_UNICODE);

//        dump($params);
//        die ;

        return self::curl(config('server.upload_config_url'), $params);
    }

}