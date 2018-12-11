<?php

namespace App\Traits;
use Illuminate\Support\Facades\Log;

/**
 * 活动数据验证
 * Trait ActivityValidateTrait
 * @package App\Traits
 */
trait ActivityValidateTrait
{
    /**
     * 获取类型方法
     * @param $actType
     * @return string
     */
    private function _getMethod($actType){
        return'_getValidateByType_'.$actType;
    }
    /**
     * 活动数据验证
     * @param $actType 活动类型
     * @param $param 活动参数
     * @param boolean $format 是否需要组装活动数据
     * @return array
     */
    public function getActivityValidate($actType,$param,$format=true){

        $list = config('activity.activity_type_list');

        if(!isset($list[$actType])){
            return false;
        }

        if(isset($param['_token'])){
            unset($param['_token']);
        }
        if(isset($param['_method'])){
            unset($param['_method']);
        }
        if($format){
            $method = $this->_getMethod($actType);
            $param  = $this->$method($param);
        }
        return $param;
    }

    /*↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓指定活动类型数据验证格式化↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓*/
    /**
      拉新活动类型 数据验证
     * @param $param
     * @return mixed
     */
    private function _getValidateByType_1($param)
    {
        //奖励数据
        $param['rank_award'] = [];
        if(isset($param['rank_min']) && isset($param['rank_max']) && isset($param['coins'])){
            $tmp = [] ;
            foreach ($param['rank_min'] as $key=>$item) {
                $tmp[$key+1] = [
                    'rank_min'=>$item,
                    'rank_max'=>$param['rank_max'][$key],
                    'coins'=>$param['coins'][$key],
                ];
            }
            $param['rank_award'] = $tmp ;
            unset($param['rank_min'],$param['rank_max'],$param['coins']);
        }

        //概率数据
        $param['card_rate'] = [];
        if(isset($param['card']) && isset($param['rate']) && isset($param['award_score'])&& isset($param['award_coins'])){
            $tmp = [] ;
            $totle = 0 ;
            foreach ($param['card'] as $card=>$item) {
                $rate = $param['rate'][$card];
                $totle += $rate;
                $tmp[$card] = [
                    'card'=>$card,
                    'rate'=>$rate,
                    'award_score'=>$param['award_score'][$card],
                    'award_coins'=>$param['award_coins'][$card],
                ];
            }
            if($totle != 100){
                Log::info(__METHOD__.' error rate totle is no 100 (rate:'.$totle);
                return false;
            }
            $param['card_rate'] = $tmp ;
            unset($param['card'],$param['rate'],$param['award_score'],$param['award_coins']);
        }
        return $param;
    }
}


