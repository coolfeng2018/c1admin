<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/10/30 11:13
 * +------------------------------
 */

namespace App\Repositories;

use App\Library\Tools\Covert;
use App\Models\SysGameListModel;
use Illuminate\Support\Facades\DB;

class GameListRepository extends BaseRepository
{
    private static $vip_config = 'game_list.lua';

    /**
     * 上传配置
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadGameListConfig()
    {
        $result = app(SysGameListModel::class)->select('game_type as u_game_type','position as u_position','shown_type as u_shown_type','notice_type as u_notice_type','status as u_status','guide_status')->get()->toArray();
        $data = [];
        if(empty($result)){
            return false;
        }
        foreach ($result as $key => $val){
            $data[$key]['game_type'] = $val['u_game_type'];
            $data[$key]['name'] = config('game.game_list')[$val['u_game_type']];
            $data[$key]['position'] = $val['u_position'];
            $data[$key]['shown_type'] = $val['u_shown_type'];
            $data[$key]['notice_type'] = $val['u_notice_type'];
            $data[$key]['status'] = $val['u_status'];
            $data[$key]['guide_status'] = $val['guide_status'];
        }
//        p(Covert::arrayToLuaStr($data));exit;
        $params = json_encode([self::$vip_config => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);
        return self::curl(config('server.upload_config_url'), $params);
    }
}