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
use App\Models\SysActivityListModel;

/**
 * 活动列表
 * Class SysConfigRepository
 * @package App\Repositories
 */
class SysActivityListRepository extends BaseRepository
{
    /**
     * 获取指定活动类型方法
     * @param $actType
     * @return string
     */
    private static function _getActLuaFileNameByType($actType){
        return "activity_{$actType}.lua";
    }

    /**
     * 获取全部活动方法
     * @return string
     */
    private static function _getActLuaFileName(){
        return "activity.lua";
    }

    /**
     * 获取格式化类型方法
     * @param $actType
     * @return string
     */
    private static function _getMethod($actType){
        return '_formatActivityByType_'.$actType;
    }

    /**
     * 推送活动数据到server
     * @param $actType 活动类型
     * @param $data 活动数据
     * @param bool $format 是否需要格式化
     * @return bool|string
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function postActivityDataToServer($actType,$data,$format=true){
        if(empty($data)){
            return false ;
        }
        if($format) {
            //是否需要格式化活动数据
            $method = self::_getMethod($actType);
            $data = self::$method($data);
        }

        $params = json_encode([self::_getActLuaFileNameByType($actType) => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);

        return self::curl(config('server.upload_config_url'), $params);
    }

    /**
     * 推送全部活动数据数据到server
     * @param bool $format 是否需要格式化
     * @return bool|string
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function postAllActivityDataToServer($format=true){

        $tmp = [] ;
        $data = SysActivityListModel::query()->get()->toArray();
        if($data){
            foreach ($data as $item) {
                $actId = $item['id'];
                if($format){
                    $actType = $item['act_type'];
                    $method = self::_getMethod($actType);
                    $tmp[$actId] = self::$method($item['act_info']);
                }else{
                    $tmp[$actId] = $item['act_info'];
                }
            }
        }
        if($tmp){
            $params = json_encode([self::_getActLuaFileName() => Covert::arrayToLuaStr($tmp)], JSON_UNESCAPED_UNICODE);
            return self::curl(config('server.upload_config_url'), $params);
        }
        return self::ERROR_FLAG;
    }


    /*↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓指定活动类型数据发送格式化↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓*/
    /**
     * 格式化活动数据方法
     * (拉新活动 类型)
     * @param $data 活动数据
     * @return array
     */
    private static function _formatActivityByType_1($data){

        $rankAward = $cardRate = [];

        if(isset($data['rank_award'])){
            $i = 0 ;
            foreach ($data['rank_award'] as $item) {
                $i = $i + 1;
                $rankAward[$i] = $item;
            }
        }
        if(isset($data['card_rate'])){
            foreach ($data['card_rate']  as $key=>$item) {
                $cardRate[$key] = $item;
            }
        }

        $tmp = [
            'ac_id'=> $data['act_id'],
            'ac_type'=> $data['act_type'],
            'ac_name'=> $data['act_name'],
            'ac_begin_time'=> $data['start_time'],
            'ac_end_time'=> $data['end_time'],
            'ac_close_intertval'=> $data['act_close_intertval'],
            'open_state'=> empty($data['status']) ? false : true ,
            'ac_content'=>[
                "double_start_time"=>$data['double_start_time'],
                "double_end_time"=>$data['double_end_time'],
                "bind_add_count"=>$data['bind_add_count'],
                "bind_condition"=>$data['bind_condition'],
                "advert_add_count"=>$data['advert_add_count'],
                "advert_condition"=>$data['advert_condition'],
                "award_cost"=>$data['award_cost'],
                "store_warn"=>$data['store_warn'],
                "robot_refresh_time"=>[$data['robot_refresh_time_min'],$data['robot_refresh_time_max']],
                "robot_refresh_score"=>[$data['robot_refresh_score_min'],$data['robot_refresh_score_max']],
                "rank_award"=>$rankAward,
                "card_rate"=>$cardRate,
            ]
        ];
        return $tmp;
    }
}