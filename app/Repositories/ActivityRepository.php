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
use App\Models\TmpActPullNewBindModel;
use App\Models\TmpActPullNewPumpModel;
use App\Models\TmpActPullNewRewardModel;
use Illuminate\Support\Facades\DB;

/**
 * 活动
 * Class BrocastRepository
 * @package App\Repositories
 */
class ActivityRepository extends BaseRepository
{

    /**
     * 获取活动排行榜数据
     * @param $actType 活动类型
     * @param array $params
     * @return bool
     */
    public static function getActivityRank($actType,$params=[]){

        $params['cmd'] = "get_act_rank_list";
        $params['ac_type'] = intval($actType);

        $data = self::apiCurl(config('server.server_api').'/activity',$params);

        if($data && isset($data['result'])){
            return $data['result'];
        }

        return false ;
    }

    /**
     * 添加活动积分
     * @param $actType 活动类型
     * @param $uid 机器人id
     * @param $score 积分
     * @return bool
     */
    public static function addActivityScore($actType,$uid,$score){

        $params['cmd'] = "add_act_robot_score";
        $params['ac_type'] = intval($actType);
        $params['uid'] = intval($uid);
        $params['score'] = intval($score);

        $data = self::apiCurl(config('server.server_api').'/activity',$params);

        if($data){
            return true;
        }

        return false ;
    }

    /**
     * 添加机器人
     * @param $actType 活动类型
     * @param $name 机器人名称
     * @param $score 积分
     * @return bool
     */
    public static function addActivityRobot($actType,$name,$score){

        $params['cmd'] = "add_act_rank_robot";
        $params['ac_type'] = intval($actType);
        $params['name'] = $name;
        $params['score'] = intval($score);

        $data = self::apiCurl(config('server.server_api').'/activity',$params);

        if($data){
            return true;
        }

        return false ;
    }

    /**
     * 获取指定时间的发奖详情
     * @param $date 时间
     * @return array
     */
    public static function getPullNewAwardData($date){
        $date = strtotime($date);
        $model = TmpActPullNewRewardModel::query();
        if($date){
            $model->where('time','>=',$date);
        }
        $data = $model->first(['award_list']);
        $awardList = [] ;
        if($data){
            $awardList = $data->award_list;
        }
        return $awardList;
    }

    /**
     * 获取排行榜数据
     * @param $sdate
     * @param $edate
     * @return array
     */
    public static function getPullNewData($sdate,$edate){
        $sdate = strtotime($sdate);
        $edate = strtotime($edate);
        $pumps = self::_getPumpData($sdate,$edate);
        if($pumps){
            $binds = self::_getBindData($sdate,$edate);
            $frees = self::_getFreeData($sdate,$edate);
            $times = self::_getAwardTimes($sdate,$edate);
            foreach ($pumps as $date => $pump) {
                $pumps[$date]['binds'] = isset($binds[$date]) ? $binds[$date]['binds'] : 0 ;
                $pumps[$date]['free_times'] = isset($frees[$date]) ? $frees[$date]['free_times'] : 0 ;
                $pumps[$date]['is_award'] = isset($times[$date]) ? true : false ;
            }
        }
        return $pumps ;
    }

    /**
     * 获取绑定数据
     * @param $sdate 开始时间
     * @param $edate 结束时间
     * @return array
     */
    private static function _getBindData($sdate,$edate){

        $model = TmpActPullNewBindModel::query();
        if($sdate){
            $model->where('time','>=',$sdate);
        }
        if($edate){
            $model->where('time','<=',$edate);
        }
        $data = $model->groupBy(['date'])->get([DB::raw('DATE_FORMAT(from_unixtime(time),"%Y-%m-%d") as date'),DB::raw('count(id) as binds')])->toArray();
        $tmp = [] ;
        if($data){
            foreach ($data as $item) {
                $tmp[$item['date']] = $item;
            }
            unset($data);
        }
        return $tmp;
    }

    /**
     * 获取抽奖数据
     * @param $sdate 开始时间
     * @param $edate 结束时间
     * @return array
     */
    private static function _getPumpData($sdate,$edate){

        $model = TmpActPullNewPumpModel::query();
        if($sdate){
            $model->where('time','>=',$sdate);
        }
        if($edate){
            $model->where('time','<=',$edate);
        }
        //统计数据
        $data = $model->groupBy(['date'])->get([
            DB::raw('DATE_FORMAT(from_unixtime(time),"%Y-%m-%d") as date'),
            DB::raw('COUNT(uid) AS payer_times'),
            DB::raw('COUNT( DISTINCT uid) AS payer_pops'),
            DB::raw('SUM(pay_coin) AS pay_coins'),
            DB::raw('SUM(award_coin) AS award_coins'),
           ])->toArray();

        $tmp = [] ;
        if($data){
            foreach ($data as $item) {
                $tmp[$item['date']] = $item;
            }
            unset($data);
        }
        return $tmp;
    }

    /**
     * 获取抽奖数据
     * @param $sdate 开始时间
     * @param $edate 结束时间
     * @return array
     */
    private static function _getFreeData($sdate,$edate){

        $model = TmpActPullNewPumpModel::query()->where('pay_coin',0);
        if($sdate){
            $model->where('time','>=',$sdate);
        }
        if($edate){
            $model->where('time','<=',$edate);
        }
        //免费次数
        $data = $model->groupBy(['date'])->get([
            DB::raw('DATE_FORMAT(from_unixtime(time),"%Y-%m-%d") as date'),
            DB::raw('COUNT(uid) AS free_times'),
        ])->toArray();

        $tmp = [] ;
        if($data){
            foreach ($data as $item) {
                $tmp[$item['date']] = $item;
            }
            unset($data);
        }
        return $tmp;
    }

    /**
     * 获取指定时间内是否有发奖
     */
    private static function _getAwardTimes($sdate,$edate){

        $model = TmpActPullNewRewardModel::query();
        if($sdate){
            $model->where('time','>=',$sdate);
        }
        if($edate){
            $model->where('time','<=',$edate);
        }

        $data = $model->groupBy(['date'])->get([
            DB::raw('DATE_FORMAT(from_unixtime(time),"%Y-%m-%d") as date'),
        ])->toArray();

        $tmp = [] ;
        if($data){
            foreach ($data as $item) {
                $tmp[$item['date']] = $item;
            }
            unset($data);
        }
        return $tmp;
    }
}