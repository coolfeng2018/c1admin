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
use App\Models\DataUnionOrderModel;
use App\Models\SysPayListsModel;

/**
 * 银行卡转账订单列表
 * Class SysConfigRepository
 * @package App\Repositories
 */
class DataUnionOrderRepository extends BaseRepository
{
    /**
     * 服务器人工订单下单
     * @param $uid
     * @param $money
     * @param  int $givePercent 赠送百分比
     * @param  int $giveCoins 赠送金币
     * @param string $paymentChannel
     * @param string $channel
     * @return mixed
     */
    public static function createOrder($uid,$money,$givePercent=0,$giveCoins=0,$paymentChannel='gm',$channel='window')
    {
        $params = [
            "payment_channel"=>$paymentChannel,
            "pay_amount"=>intval($money),
            "channel"=>$channel,
            "uid"=> $uid
        ];
        $data = self::apiCurl(config('pay.manual.create_order_url'),$params);
        if($data && isset($data['order_id'])){
            $orderId = $data['order_id'];
            $redis = app('redis.connection');
            $info = ['orderCode'=>$orderId,'ex_percent'=>$givePercent,'ex_coins'=>$giveCoins] ;
            $redis->select(5);
            $redis->lpush(config('cacheKey.REDIS_PAY_ORDER_QUEUE'), json_encode($info));
            return  $info;
        }
        return false;
    }

    /**
     * 定时关闭过期未处理的订单
     */
    public static function cliUpdateOrderStatus()
    {
        $time = time();
        $info = DataUnionOrderModel::query()->where('o_status',0)->get(['id','uid','created_at']);
        $ret = [] ;
        if($info){
            //获取过期时间设置
            $receInfo = SysPayListsRepository::getActivePaysByType(SysPayListsModel::PAY_WAY_UNIONCARD);
            $len = isset($receInfo->pay_info['rece_time_limit']) ? $receInfo->pay_info['rece_time_limit'] * 60 : 0 ;
            foreach ($info as $item) {
                if((strtotime($item->created_at) + $len) < $time ){
                    // 过期关闭订单
                    DataUnionOrderModel::where('id',$item->id)
                        ->update(['o_status'=>2,'o_desc'=>'系统自动关闭','op_name'=>'gm','updated_at'=>$time]);
                    $ret[$item->id] = $item->uid ;
                }
            }
        }
        return $ret;
    }
}