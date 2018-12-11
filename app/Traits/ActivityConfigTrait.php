<?php

namespace App\Traits;
/**
 * 活动配置选项
 * Trait ActivityConfigTrait
 * @package App\Traits
 */
trait ActivityConfigTrait
{
    /**
     * 根据活动类型 获取对应的差异化 参数
     * @param int $actType 活动类型
     * @return array
     */
    public function getActivityItemConfig($actType=1,$ActivityRepository=null){
        $list = config('activity.activity_type_list');
        if(!isset($list[$actType])){
            return [];
        }
        $method = '_getConfigByType'.$actType;
        return $this->$method($actType,$ActivityRepository);
    }

    /**
     * 拉新活动类型 config
     * @param $actType
     * @param null $ActivityRepository
     * @return array
     */
    private function _getConfigByType1($actType,$ActivityRepository=null){
        $list = [] ;
        $list['card_rate'] = config('activity.type_'.$actType.'.card_rate');
        //实时库存值
        $list['store_real'] = $this->getActStoreReal($actType,$ActivityRepository);
        return $list;
    }

    /**
     * 获取拉新活动-实时库存
     * @param $actType 活动类型
     * @param $ActivityRepository
     * @return int
     */
    public function getActStoreReal($actType,$ActivityRepository=null){

        if($ActivityRepository){

            $params['cmd'] = "get_act_store";
            $params['ac_type'] = intval($actType);

            $data = $ActivityRepository::apiCurl(config('server.server_api').'/activity',$params);
            if($data && isset($data['store_coins'])){
                return $data['store_coins'];
            }
        }
        return 0 ;
    }

    /**
     * 设置拉新活动-实时库存
     * @param $actType 活动类型
     * @param $coins 库存值
     * @param $ActivityRepository
     * @return bool
     */
    public function setActStoreReal($actType,$coins,$ActivityRepository=null){

        if($ActivityRepository){

            $params['cmd'] = "set_act_store";
            $params['ac_type'] = intval($actType);
            $params['coins'] = intval($coins);

            $data = $ActivityRepository::apiCurl(config('server.server_api').'/activity',$params);
            if($data && isset($data['code']) && $data['code'] == 0){
                return true;
            }
        }
        return false ;
    }
}


