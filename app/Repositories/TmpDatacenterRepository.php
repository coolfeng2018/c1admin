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
use App\Models\TmpUserResultModel;
use App\Models\TmpPaymentOrderModel;
use App\Models\TmpWidthdrawModel;
use Illuminate\Support\Facades\DB;

/**
 * 充值和兑换统计
 * Class SysConfigRepository
 * @package App\Repositories
 */
class TmpDatacenterRepository extends BaseRepository
{
    /**
     *  获取充值和兑换数据
     * @param string $channel
     * @param string $sdate
     * @param string $edate
     * @return mixed
     */
    public function getDataList($channel='all',$sdate='',$edate=''){
        //基本数据
        $remain = $this->_getInfomation($channel,$sdate,$edate);
        //兑换数据
        $exchangeData = $this->getAllExchange($channel,$sdate,$edate);
        //充值数据
        $payData = $this->getPayList($channel,$sdate,$edate);
        //拼接总兑换、总收入
        foreach ($remain['data'] as &$val) {
            //总兑换
            $val['ecoin'] = isset($exchangeData[$val['time']]) ? $exchangeData[$val['time']] : 0 ;
            //总收入
            $val['paysum'] = isset($payData[$val['time']]) ? $payData[$val['time']] : 0 ;
        }
        //需要统计当日实时数据
        $todayRemain = $this->getTodayInfomation($channel);
        $remain['data'] = $this->initRemainData(array_unshif_data($remain['data'],$todayRemain));
        //新增用户充值人数
        $remain['data'] = $this->getNewUserRechargeCount($remain['data']);
        //新增用户充值总额
        $remain['data'] = $this->getNewUserRechargeSum($remain['data']);
        //新增提现总额
        $remain['data'] = $this->getWidthdrawSum($remain['data']);
        //总充值人数
        $remain['data'] = $this->getPaymentOrderCount($remain['data']);
        return $remain;
    }

    /**
     *  转换充值兑换单位
     * @param $data
     * @return mixed
     */
    public function initRemainData($data){
        foreach ($data as $key => $value){
            $data[$key]['rn1'] = ($value['rn1']*100).'%';//次日留存
            $data[$key]['paysum'] = ($value['paysum']/100);
        }
        return $data;
    }

    /**
     * 获取今日统计信息
     * @param string $channel
     * @return mixed
     */
    public function getTodayInfomation($channel='all'){
        $now = date('Ymd');
        $ecoins =  $this->getAllExchange($channel);
        $paysums = $this->getPayList($channel);
        $today['dnu'] = $this->getNewUserCount($channel); // 新增用户
        $today['dau'] = $this->getActiveUserCount($channel); // 活跃用户
        $today['rn1'] = 0;
        $today['ecoin'] = isset($ecoins[$now]) ? $ecoins[$now] : 0 ;
        $today['paysum'] =  isset($paysums[$now]) ? $paysums[$now] : 0 ;
        $today['time'] = $now;
        return $today;
    }

    /**
     * 获取统计信息
     * @param string $channel 渠道
     * @param string $sdate 开始日期
     * @param string $edate 结束日期
     * @return mixed
     */
    public function _getInfomation($channel='all',$sdate='',$edate='') {
        $model = TmpUserResultModel::query();
        $model = $model->whereBetween('time',[$sdate,$edate]);
        if($channel){
            $model = $model->where('channel','=',$channel);
        }
        $result = $model->orderBy('time','desc')->paginate(10)->toArray();
        return $result;
    }

    /*****************************************************************************************************/
    /**
     * 获取格式化总兑换数
     * @param $channel 渠道
     * @param int $starttime 开始时间
     * @param int $endtime 结束时间
     * @return array
     */
    public function getAllExchange($channel,$starttime=0,$endtime=0){
        $list = $this->_exchangeList($channel,$starttime,$endtime);
        return $this->_formatData($list);
    }

    /**
     * 获取总兑换数
     * @param $channel 渠道
     * @param int $starttime 开始时间
     * @param int $endtime 结束时间
     * @return mixed
     */
    private function _exchangeList($channel,$starttime,$endtime){
        $channel = strval($channel);
        $starttime = intval($starttime);
        $endtime = intval($endtime);
        $where = " WHERE `status`=1 ";
        $starttime = ($starttime > 0) ? $starttime : strtotime(date('Y-m-d 00:00:00'));
        $where .= " AND UNIX_TIMESTAMP(CreateAt) > {$starttime}";
        $endtime = ($endtime > 0) ? $endtime : strtotime(date('Y-m-d 23:59:59'));
        $where .= " AND UNIX_TIMESTAMP(CreateAt) < {$endtime}";

        $connection = DB::connection(config('constants.MYSQL_ONE_BY_ONE'));

        $subsql = "SELECT uid,DATE_FORMAT(CreateAt, '%Y%m%d') AS CreateAt,Amount  FROM  withdraw {$where} ";
        if($channel != 'all'){
            $sql = "SELECT b.CreateAt,b.Amount FROM `dcusers`  AS a,({$subsql}) AS b WHERE a.uid = b.uid AND a.channel = '{$channel}'";
            $data = $connection->select($sql);
        }else{
            $data = $connection->select($subsql);
        }
        return $data;
    }

    /**
     * 总收入统计
     * @param $channel   渠道名称
     * @param int $starttime  开始日期
     * @param int $endtime    结束日期
     * @return array
     */
    public function getPayList($channel,$starttime=0,$endtime=0){
        $channel = strval($channel);
        $starttime = intval($starttime);
        $endtime = intval($endtime);
        $where = " WHERE `status`=2 ";
        $starttime = ($starttime > 0) ? $starttime : strtotime(date('Y-m-d 00:00:00'));
        $where .= " AND create_time > {$starttime}";
        $endtime = ($endtime > 0) ? $endtime : strtotime(date('Y-m-d 23:59:59'));
        $where .= " AND create_time < {$endtime}";
        if ($channel != 'all'){
            $where .= " AND channel =  '{$channel}'";
        }
        //通过时间查询所有订单信息
        $sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y%m%d') AS CreateAt,channel As channel,amount AS Amount,uid AS uid  FROM  payment.order {$where} ";
        $payConnection = DB::connection(config('constants.MYSQL_PAYMENT'));
        $data = $payConnection->select($sql);
        if (empty($data)){
            return array();
        }
        $orderData = array();
        $uidArr = array();
        foreach ($data as $val){
            $val = (array)$val;
            $orderData[$val['CreateAt']][$val['uid']][] =  $val['Amount'];
            $uidArr[] = $val['uid'];
        }

        foreach ($orderData as $key => $val){
            foreach ($val as $k=>$v){
                $list[$key][]= array_sum($v);
            }
        }
        foreach ($list as $key => $val){
            $list[$key] = array_sum($val);
        }
        return $list;

//
//        if ($channel == 'all'){
//            foreach ($orderData as $key => $val){
//                foreach ($val as $k=>$v){
//                    $list[$key][]= array_sum($v);
//                }
//            }
//            foreach ($list as $key => $val){
//                $list[$key] = array_sum($val);
//            }
//            return $list;
//        }
//        // 计算单日用户总数据
//        foreach ($orderData as $key => $val){
//            foreach ($val as $k=>$v){
//                $orderData[$key][$k]= array_sum($v);
//            }
//        }
//        $uidArr = array_unique($uidArr);
//        $uidStr = implode(',', $uidArr);
//        $sql = "SELECT uid,channel FROM one_by_one.dcusers where  uid in (".$uidStr.") AND channel='".$channel."'";
//        $oneByOneConnection = DB::connection(config('constants.MYSQL_ONE_BY_ONE'));
//
//        $restData = $oneByOneConnection->select($sql);
//        if (empty($restData)){
//            return array();
//        }
//        $data = array();
//        foreach ($restData as $val){
//            $data[$val->uid] = $val->channel;
//        }
//
//        $uidArr = array_keys($data);
//        $list = array();
//        foreach ($orderData as $key => $val){
//            foreach ($val as $k=>$v){
//                if (in_array($k,$uidArr)){
//                    $list[$key][] = $orderData[$key][$k];
//                }
//            }
//        }
//        foreach ($list as $key=>$val){
//            $list[$key] = array_sum($val);
//        }
//        return $list;
    }

    /**
     * 获取今日新注册用户数
     * @param type $channel
     * @param int $op 默认200000=>玩家注册
     * @return type
     */
    public function getNewUserCount($channel, $op=200000) {
        $connectDatabase = DB::connection(config('constants.MYSQL_DATA_CENTER'));
        $query = $connectDatabase->table('dc_log_user.user'.date('Ym'))
            ->whereBetween('time',[strtotime(date('Y-m-d 00:00:00')),strtotime(date('Y-m-d 23:59:59'))])
            ->where(['op' => $op]);
        if ($channel != 'all') {
            $query = $query->where(['channel' => $channel]);
        }
        return $query->count('id');
    }

    /**
     * 获取当日新注册用户
     * @param $sdate 当日时间
     * @param string $channel 渠道
     * @param int $op 默认200000=>玩家注册
     * @return array
     */
    public  function  getNewUser($sdate,$channel='all',$op=200000){
        $starTime = $sdate ? date('Y-m-d 00:00:00',$sdate) : strtotime(date('Y-m-d 00:00:00'));
        $endTime = $sdate ? date('Y-m-d 23:59:59',$sdate) : strtotime(date('Y-m-d 23:59:59'));
        $suffixDate = $sdate ? date('Ym',$sdate) : date('Ym');
        $connectDatabase = DB::connection(config('constants.MYSQL_DATA_CENTER'));
        $query = $connectDatabase->table('dc_log_user.user'.$suffixDate)
            ->whereBetween('time',[strtotime($starTime),strtotime($endTime)])
            ->where(['op' => $op]);
        if ($channel != 'all') {
            $query = $query->where(['channel' => $channel]);
        }
        $uids = [];
        $query = $query->get(['uid'])->toArray();
        if(count($query)>0){
            foreach ($query as $k => $v){
                $uids[] = $v->uid;
            }
        }
        return $uids;
    }

    /**
     * 获取活跃用户数
     * @param type $channel
     * @param int $op 默认200001=>玩家登陆
     * @return type
     */
    public function getActiveUserCount($channel, $op=200001) {
        $connectDatabase = DB::connection(config('constants.MYSQL_DATA_CENTER'));
        $sql = "select distinct uid from dc_log_user.user".date('Ym')." where time".
            " between ".strtotime(date('Y-m-d 00:00:00'))." and ".strtotime(date('Y-m-d 23:59:59')).
            " and op={$op} ";
        if ($channel != 'all') {
            $sql .= " and channel='".$channel."'";
        }
        $data = $connectDatabase->select($sql);
        return count($data);
    }

    /**
     * 新增用户充值人数
     * @param $data
     * @return mixed
     */
    public function getNewUserRechargeCount($data){
        if(count($data)<0){
            return $data;
        }
        foreach ($data as $key => $value){
            //获取当天用户数组
            $uids = $this->getNewUser(strtotime($value['time']));
            $count = 0;
            if(count($uids)>0){
                $model = app(TmpPaymentOrderModel::class);
                $count = $model->getNewRechargeUserCount($uids);
            }
            $data[$key]['recharge_count'] = $count;
        }
        return $data;
    }

    /**
     * 总充值人数
     * @param $data
     * @return mixed
     */
    public function getPaymentOrderCount($data){
        if(count($data)<0){
            return $data;
        }
        foreach ($data as $key => $value){
            //获取当天用户数组
            $model = app(TmpPaymentOrderModel::class);
            $time = strtotime(date('Y-m-d 23:59:59',strtotime($value['time'])));
            $count = $model->getUserRechargeSum($time);
            $data[$key]['recharge_sum'] = $count;
        }
        return $data;
    }

    /**
     * 新增用户充值总额
     * @param $data
     * @return mixed
     */
    public function getNewUserRechargeSum($data){
        if(count($data)<0){
            return $data;
        }
        foreach ($data as $key => $value){
            //获取当天用户数组
            $uids = $this->getNewUser(strtotime($value['time']));
            $count = 0;
            if(count($uids)>0){
                $model = app(TmpPaymentOrderModel::class);
                $count = $model->getNewUserRechargeSum($uids);
            }
            $data[$key]['new_recharge_sum'] = $count;
        }
        return $data;
    }

    /**
     * 新增提现总额
     * @param $data
     * @return mixed
     */
    public function getWidthdrawSum($data){
        if(count($data)<0){
            return $data;
        }
        foreach ($data as $key => $value){
            //获取当天用户数组
            $uids = $this->getNewUser(strtotime($value['time']));
            $count = 0;
            if(count($uids)>0){
                $model = app(TmpWidthdrawModel::class);
                $count = $model->getWidthdrawSum($uids);
            }
            $data[$key]['widthdraw_sum'] = $count;
        }
        return $data;
    }

    /**
     * 格式化数据
     * @param $list 数据结果集
     * @return array
     */
    private function _formatData($list){
        if(empty($list)){
            return array();
        }
        $result = array();
        foreach ($list as $item) {
            if(!isset($result[$item->CreateAt])){
                $result[$item->CreateAt] = $item->Amount;
            }else{
                $result[$item->CreateAt] += $item->Amount;
            }
        }
        unset($list);
        return $result ;
    }
}