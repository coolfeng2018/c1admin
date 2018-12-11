<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\12\5 0005
 * Time: 15:19
 */

namespace App\Repositories;

use App\Library\Tools\Covert;
use App\Models\SysErrorCodeModel;

class ErrorCodeRepository extends BaseRepository
{
    private static $error_config = 'error_des.lua';

    /**
     * 上传错误码配置
     */
    public static function uploadErrorCodeConfig(){
        $result = SysErrorCodeModel::query()->select('error_code','error_name')->pluck('error_name','error_code')->toArray();
        $data = [];
        if(!$result){
            return false;
        }
        $data = $result;
        $params = json_encode([self::$error_config => Covert::arrayToLuaStr($data)],JSON_UNESCAPED_UNICODE);
        return self::curl(config('server.upload_config_url'), $params);
    }
}