<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/20 19:52
 * +------------------------------
 */

namespace App\Repositories;


use App\Library\Tools\Covert;
use App\Models\SysConfigModel;


/**
 * 全局单页配置上传
 * Class SysConfigRepository
 * @package App\Repositories
 */
class SysConfigRepository extends BaseRepository
{
    /**
     * 上传排行榜配置
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadRankConfig()
    {
        $result = SysConfigModel::getSysVal(SysConfigModel::RANK_CONTROL_KEY);
        if (!$result) return self::ERROR_FLAG;

        //处理show
        if (isset($result['show']) && count($result['show']) > 0) {
            $result['show'] = array_keys($result['show']);
        }
        //处理范围值
        $result['robot_change'] = [$result['robot_change_min'], $result['robot_change_max']];
        unset($result['robot_change_min']);
        unset($result['robot_change_max']);

        //解析lua
        $params = json_encode([SysConfigModel::RANK_CONTROL_KEY => Covert::arrayToLuaStr($result)]);

//        dump($params);
//        die;

        return self::curl(config('server.upload_config_url'), $params);
    }


    /**
     *
     */
    public static function updateUserTriggerConfig()
    {
        $result = SysConfigModel::getSysVal(SysConfigModel::USER_TRIGGER_KEY);
        if (!$result) return self::ERROR_FLAG;

        //处理

        //解析lua
        $params = json_encode([SysConfigModel::USER_TRIGGER_KEY => Covert::arrayToLuaStr($result)]);

//        dump($params);
//        die;

        return self::curl(config('server.upload_config_url'), $params);
    }

    /**
     *
     */
    public static function updateUserGuideConfig()
    {
        $result = SysConfigModel::getSysVal(SysConfigModel::USER_GUIDE_KEY);
        if (!$result) return self::ERROR_FLAG;

        //处理


        //解析lua
        $params = json_encode([SysConfigModel::USER_GUIDE_KEY => Covert::arrayToLuaStr($result)]);

//        dump($params);
//        die;

        return self::curl(config('server.upload_config_url'), $params);
    }

    /**
     *
     */
    public static function updatePersonalControlConfig()
    {
        $result = SysConfigModel::getSysVal(SysConfigModel::PERSONAL_CONTROL_KEY);
        if (!$result) return self::ERROR_FLAG;

        //处理


        //解析lua
        $params = json_encode([SysConfigModel::PERSONAL_CONTROL_KEY => Covert::arrayToLuaStr($result)]);

//        dump($params);
//        die;

        return self::curl(config('server.upload_config_url'), $params);
    }

    /**
     * 百人牛牛机器人控制
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadBrnnConfig()
    {
        $result = SysConfigModel::getSysVal(SysConfigModel::ROBOT_BANKER_CONTROL_KEY);
//        p($result);exit;
        if (!$result) return self::ERROR_FLAG;

        //添加brnn_normal
        $newResult['brnn_normal'] = $result;

        //处理banker_rate
        if(isset($result['banker_rate_people_min']) > 0){
            $result['banker_rate'] = [];
            for ($i = 0; $i < count($result['banker_rate_people_min']); $i++){
                $result['banker_rate'][$i]['min'] = $result['banker_rate_people_min'][$i];
                $result['banker_rate'][$i]['max'] = $result['banker_rate_people_max'][$i];
                $result['banker_rate'][$i]['rate'] = $result['banker_rate_rate_min'][$i];
                $result['banker_rate'][$i]['number'] = $result['banker_rate_people_num_min'][$i];
            }
        }
        //处理banker_round
        if(isset($result['banker_round_coin_min']) > 0){
            $result['banker_round'] = [];
            for ($i = 0; $i < count($result['banker_round_coin_min']); $i++){
                $result['banker_round'][$i]['min'] = $result['banker_round_coin_min'][$i];
                $result['banker_round'][$i]['max'] = $result['banker_round_coin_max'][$i];
                $result['banker_round'][$i]['round_range'] = $result['banker_round_round_range_min'][$i].'-'.$result['banker_round_round_range_max'][$i];
            }
        }
        unset($result['banker_rate_people_min']);
        unset($result['banker_rate_people_max']);
        unset($result['banker_rate_rate_min']);
        unset($result['banker_rate_people_num_min']);
        unset($result['banker_round_coin_min']);
        unset($result['banker_round_coin_max']);
        unset($result['banker_round_round_range_min']);
        unset($result['banker_round_round_range_max']);
        $newResult['brnn_normal'] = $result;
        //解析lua
        $params = json_encode([SysConfigModel::ROBOT_BANKER_CONTROL_KEY => Covert::arrayToLuaStr($newResult)]);
//        echo $params;exit;
//        dump($params);
//        die;
        return self::curl(config('server.upload_config_url'), $params);
    }


    /**
     * 百人牛牛十倍场-机器人控制
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadBrnnTenConfig()
    {
        $list['brnn_ten_normal'] = self::brnnData(SysConfigModel::getSysVal(SysConfigModel::ROBOT_TEN_BANKER_CONTROL_KEY));
        $list['brnn_normal'] = self::brnnData(SysConfigModel::getSysVal(SysConfigModel::ROBOT_BANKER_CONTROL_KEY));
        $params = json_encode([SysConfigModel::ROBOT_BANKER_CONTROL_KEY => Covert::arrayToLuaStr($list)]);
        return self::curl(config('server.upload_config_url'), $params);
    }


    public static function brnnData($result){
        //        p($result);exit;
        if (!$result) return self::ERROR_FLAG;

        //处理banker_rate
        if(isset($result['banker_rate_people_min']) > 0){
            $result['banker_rate'] = [];
            for ($i = 0; $i < count($result['banker_rate_people_min']); $i++){
                $result['banker_rate'][$i]['min'] = $result['banker_rate_people_min'][$i];
                $result['banker_rate'][$i]['max'] = $result['banker_rate_people_max'][$i];
                $result['banker_rate'][$i]['rate'] = $result['banker_rate_rate_min'][$i];
                $result['banker_rate'][$i]['number'] = $result['banker_rate_people_num_min'][$i];
            }
        }
        //处理banker_round
        if(isset($result['banker_round_coin_min']) > 0){
            $result['banker_round'] = [];
            for ($i = 0; $i < count($result['banker_round_coin_min']); $i++){
                $result['banker_round'][$i]['min'] = $result['banker_round_coin_min'][$i];
                $result['banker_round'][$i]['max'] = $result['banker_round_coin_max'][$i];
                $result['banker_round'][$i]['round_range'] = $result['banker_round_round_range_min'][$i].'-'.$result['banker_round_round_range_max'][$i];
            }
        }
        unset($result['banker_rate_people_min']);
        unset($result['banker_rate_people_max']);
        unset($result['banker_rate_rate_min']);
        unset($result['banker_rate_people_num_min']);
        unset($result['banker_round_coin_min']);
        unset($result['banker_round_coin_max']);
        unset($result['banker_round_round_range_min']);
        unset($result['banker_round_round_range_max']);
        //$newResult['brnn_normal'] = $result;
        return $result;
    }




    /**
     * TODO: 这里一个例子，另外的上传配置都和这样写方法
     */
    public static function updateXXXConfig()
    {

    }
}