<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/9/20 19:52
 * +------------------------------
 */

namespace App\Repositories;
use App\Library\Tools\Covert;
use App\Models\DataUnionOrderModel;
use App\Models\SysConfigModel;
use App\Models\SysPayListsModel;

/**
 * Class StoreRepository
 * @package App\Repositories
 */
class StoreRepository extends BaseRepository
{
    //文件名称
    private static $file_name = 'robot_store.lua';

    /**
     * 获取库存实时数据
     * @param $uid
     * @param string $headIcon
     * @param string $desc
     */
    public static function getRobotStore($robot){
        $url = config('server.server_api').'/gm';
        $param = array('cmd' =>'getrobotstore', 'robot_type' =>$robot);
        return self::apiCurl($url, $param,'POST','www');
    }


    /**
     * @param $list
     * @param $data
     * @return mixed
     */
    public static function listData($list=array(),$data){
        if (empty($list))
            return $data;
        foreach ($list as $key=>$val){
            $rest =  self::getRobotStore($key);
            if ($rest['code'] == 0){
                $data[$key]['fee_coins']          = $rest['robot_store']['fee_coins']/100;
                $data[$key]['base_curr_rate']     = $rest['robot_store']['base_curr_rate']/100;
                $data[$key]['curr_control_rate']  = $rest['robot_store']['curr_control_rate'];
                $data[$key]['award_coins']        = $rest['robot_store']['award_coins']/100;
            }else{
                $data[$key]['fee_coins']          = 0;
                $data[$key]['base_curr_rate']     = 0;
                $data[$key]['curr_control_rate']  = 0;
                $data[$key]['award_coins']        = 0;
            }
        }
        return $data;
    }

    /**
     * 水果机库存
     * @param $robot
     * @return bool|mixed|string
     */
    public static function fruitList($data){
        $url = config('server.server_api').'/gm';
       // $url = 'http://192.168.1.223:8888/gm';
        $param = array('cmd' =>'getfruitstore', 'table_type' =>200003);
        $list =  self::apiCurl($url, $param,'POST','www');
        $data['store_system_back']['curr']    = toRmb($list['fruitstore']['pool_sysback']['curr'] ?? 0);
        $data['store_base_sys']['curr']       = toRmb($list['fruitstore']['pool_base']['curr'] ?? 0);
        $data['store_adjust']['curr']         = toRmb($list['fruitstore']['pool_adjust']['curr'] ?? 0);
        $data['store_real_jackpot']['curr']   = toRmb($list['fruitstore']['pool_real_jackpot']['curr'] ?? 0);
        $data['store_unreal_jackpot']['curr'] = toRmb($list['fruitstore']['pool_unreal_jackpot']['curr'] ?? 0);
        $data['store_unreal_jackpot']['grand_rate'] = $list['fruitstore']['pool_unreal_jackpot']['send_rate'] ?? 0;
        return $data;
    }



    /**
     * @param array $data
     * @param $limit
     * @return array
     */
    public static function assemble($data = array(),$limit){
        if (empty($data))
            return $data;

        for ($i=0;$i<count($data['data']);$i++){
            if($i+1 == count($data['data'])) break;

            $data['data'][$i]['base_change']   = $data['data'][$i]['base_store'] - $data['data'][$i+1]['base_store'];
            $data['data'][$i]['award_change']  = $data['data'][$i]['award_store']- $data['data'][$i+1]['award_store'];
            $data['data'][$i]['fee_change']    = $data['data'][$i]['fee_store']  - $data['data'][$i+1]['fee_store'];
            $data['data'][$i]['rtn']           = $data['data'][$i]['award_change'] + $data['data'][$i]['base_change'] + $data['data'][$i]['fee_change'];
            $data['data'][$i]['jackpot_change']= $data['data'][$i]['jackpot_store']  - $data['data'][$i+1]['jackpot_store'];

            $data['data'][$i]['base_store']  = isset($data['data'][$i]['base_store'])  ? toRmb($data['data'][$i]['base_store'])   : 0;
            $data['data'][$i]['base_change'] = isset($data['data'][$i]['base_change']) ? toRmb($data['data'][$i]['base_change'])  : 0;
            $data['data'][$i]['award_store'] = isset($data['data'][$i]['award_store']) ? toRmb($data['data'][$i]['award_store'])  : 0;
            $data['data'][$i]['award_change']= isset($data['data'][$i]['award_change'])? toRmb($data['data'][$i]['award_change']) : 0;
            $data['data'][$i]['fee_store']   = isset($data['data'][$i]['fee_store'])   ? toRmb($data['data'][$i]['fee_store'])    : 0;
            $data['data'][$i]['fee_change']  = isset($data['data'][$i]['fee_change'])  ? toRmb($data['data'][$i]['fee_change'])   : 0;
            $data['data'][$i]['rtn']         = isset($data['data'][$i]['rtn'])         ? toRmb($data['data'][$i]['rtn'])          : 0;
            $data['data'][$i]['jackpot_store']   = isset($data['data'][$i]['jackpot_store'])   ? toRmb($data['data'][$i]['jackpot_store']) : 0;
            $data['data'][$i]['jackpot_change']  = isset($data['data'][$i]['jackpot_change'])  ? toRmb($data['data'][$i]['jackpot_change']): 0;
        }
        array_pop($data['data']);
        return $data;
    }


    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendConfig(){

        $keyArr = array(
            SysConfigModel::STORE_NN_KEY,
            SysConfigModel::STORE_ZJH_KEY,
            SysConfigModel::STORE_BRNN_KEY,
            SysConfigModel::STORE_HHDZ_KEY,
            SysConfigModel::STORE_LFDJ_KEY
        );
        $data = SysConfigModel::getManySysKeyExists($keyArr);
        $list = [];
        foreach ($data as $key=>$val){
            foreach ($val['sys_val'] as $k => $v){
                $temp  = $v;
                $temp ['base_goal'] = toMinute($v['base_goal']);
                $temp ['base_warn'] = toMinute($v['base_warn']);
                $temp ['award_warn']= toMinute($v['award_warn']);
                $lose_limit = $v['lose_limit'] ?? 0;
                if ($lose_limit){
                    $temp ['lose_limit']= toMinute($v['lose_limit']);
                }
                $list[$k] = $temp;
            }
        }
        $params = json_encode([self::$file_name => Covert::arrayToLuaStr($list)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return true;
        }
        return false;
    }

    /**
     * 大抽奖库存数据
     */
    public static function granddraw() {
        $url = config('server.server_api').'/award';
        //$url = 'http://192.168.1.27:8888/award';
        $param = ['cmd' =>'get_award_info'];
        $list =  self::apiCurl($url, $param,'POST');
        $data = [];
        if (isset($list['code']) && $list['code'] == 0) {
            $data['fee_coins'] = toRmb($list['award_data']['fee_coins']);
            $data['store_coins'] = toRmb($list['award_data']['store_coins']);
            $data['store_system_add'] = toRmb($list['award_data']['store_system_add']);
            $data['award_pool_coins'] = toRmb($list['award_data']['award_pool_coins']);
            $data['award_pool_system_add'] = toRmb($list['award_data']['award_pool_system_add']);
            $data['cur_index'] = $list['award_data']['cur_index'];
            $data['end_time'] = $list['award_data']['end_time'];
            return $data;
        }
        return $data;
    }

    /**
     * 大抽奖添加库存
     */
    public static function addGranddraw($money) {
        $url = config('server.server_api').'/award';
        //$url = 'http://192.168.1.27:8888/award';
        $param = ['cmd' =>'add_store_coins','add_coins' => $money];
        return self::apiCurl($url, $param,'POST');

    }


    public static function mammon(){
       //$url = 'http://192.168.1.223:8888/gm';
       $url = config('server.server_api').'/gm';
        $param = ['cmd'=>'getcaishenstore'];
        return self::apiCurl($url,$param,'POST','www');


    }

}