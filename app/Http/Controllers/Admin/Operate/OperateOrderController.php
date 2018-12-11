<?php

namespace App\Http\Controllers\Admin\Operate;


use App\Models\DataUnionOrderModel;
use App\Models\TmpDcusersModel;
use App\Models\OrderModel;
use App\Models\SysPayListsModel;
use App\Repositories\DataUnionOrderRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SysActivityPayRepository;
use App\Repositories\SysPayListsRepository;
use App\Repositories\TmpPlatformMailRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\Log;

class OperateOrderController extends Controller
{

    /**
     * 订单管理页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $list['stime'] = date('Y-m-d', strtotime('-6 days'));
        $list['etime'] = date('Y-m-d',time());
        $list['payList'] = OrderModel::payType();
        $list['channel'] = OrderModel::channel();
        $list['status'] = OrderModel::payStatus();
        return view('admin.operate.order.index',['list' => $list]);
    }

    /**
     * 订单管理数据请求接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $param['uid']     = $request->get('uid',null);     // 用户id
        $param['status']  = $request->get('status','0');  // 支付状态
        $param['channel'] = $request->get('channel','z');// 平台
        $param['payment_channel'] = $request->get('payment_channel','z'); // 支付渠道
        $param['stime'] = strtotime($request->get('stime',date('Y-m-d', strtotime('-6 days')))); // 开始时间
        $param['etime'] = strtotime($request->get('etime',date('Y-m-d',time())));
        $param['etime'] = $param['etime'] + 86400;
        // 结束时间
        $param['limit'] = $request->get('limit',10);
        $export    = $request->get('export',0);

        $OrderModel =  OrderModel::query();
        if ($param['uid']){
            $OrderModel->where('uid',$param['uid']);
        }
        if ($param['status'] != 'z' ){
            $OrderModel->where('status',$param['status']);
        }
        if ($param['channel'] != 'z'){
            $OrderModel->where('channel',$param['channel']);
        }
        if ($param['payment_channel'] !=  'z'){
            $OrderModel->where('payment_channel', 'like', '%'.$param['payment_channel'].'%');
        }

        $OrderModel->whereBetween('create_time',[$param['stime'],$param['etime']]);

        if ($export == 1){
            $title = "订单记录";
            $descList = [['用户id','订单号','付款方式','支付结果','平台','金额','购买时间']];
            $list = [];
            $data = $OrderModel->orderBy('create_time','desc')->get()->toArray();
            foreach ($data as $v) {
                $list[] = [$v['uid'], $v['order_id'], OrderModel::getPaymentName($v['payment_channel']), $v['status_name'], $v['channel'], $v['amount']/100, date('Y-m-d H:i:s', $v['create_time'])];
            }
            return $this->doExport($descList, $list, $title);
        }

        $goods = config('game.goods');
        $idsArr = $ordersArr = [] ;
        $data = $OrderModel->orderBy('create_time','desc')->paginate($param['limit'])->toArray();
        $list = $data['data'];

        foreach ($list as $k =>$v){
            $list[$k]['productName']      = @$goods[$v['product_id']] ?$goods[$v['product_id']]['productName']:($v['payment_channel']=='gm'?'金币'.$v['amount']:'');
            $list[$k]['payment_channel']  = OrderModel::getPaymentName($v['payment_channel']);
            $list[$k]['order_type']       = $v['payment_channel'];
            $list[$k]['status']           = $v['status'];
            $list[$k]['amount']           = round($v['amount']/100,2);
            $list[$k]['create_time']      = date('Y-m-d H:i:s', $v['create_time']);
            $idsArr[]               = $v['uid'];
            $ordersArr[]            = $v['order_id'];
        }

        $orders = DataUnionOrderModel::query()->pluck('give_money','inner_order_id');
        $users = TmpDcusersModel::query()->whereIn('uid', $idsArr)->pluck('nickname','uid');

        foreach ($list as $key => $val){
            $list[$key]['name'] =  isset($users[$val['uid']]) ? $users[$val['uid']] : '' ;
            $list[$key]['give_money'] =  isset($orders[$val['order_id']]) ? $orders[$val['order_id']] : '' ;
        }

        return $this->jsonTable($list,$data['total']);
    }

    /**
     * @param Request $request
     * @return bool|mixed|string
     */
    public function destroy(Request $request) {
        $order_id = $request->get('order_id','');
        $data = ['order_id' => $order_id];
        $url = config('server.order_api').'/starry/order/discard_order';
        $ret = OrderRepository::apiCurl($url,$data);
        return $this->json($ret);
    }

    /**
     * 人工订单添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderAdd(){
        $channel = OrderModel::channel();
       return view('admin.operate.order.add',['channel'=>$channel]);
    }

    /**
     * 人工订单数据提交接口
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function dataAdd(Request $request){
        $param['uid'] = $request->get('uid',0);
        $param['channel'] = $request->get('channel','');
        $param['amount'] = $request->get('amount','');
        $param['pay_channel'] = $request->get('pay_channel','');

        if (empty($param['uid'])){
            return  $this->json('',201,'用户ID不能为空');
        }
        if (!is_numeric($param['amount']) || $param['amount'] <= 0){
            return  $this->json('',201,'金额不能为空');
        }


        //$data = self::getMongoDb('yange_data.users',['uid'=>['$in' =>[(int)$param['uid']]]]);
        $data = self::getMongoDb('yange_data.users',['_id'=>(int)$param['uid']]);
        $channel = 'window';
        if (isset($data[0]) && !empty($data[0]->channel)){
            $channel = $data[0]->channel;
        }
        $actPoint = self::_isVipActivity();
        $info = DataUnionOrderRepository::createOrder($param['uid'],$param['amount'],$actPoint,0,'gm',$channel);
        if ($info){

            $msg = '';
            if($actPoint > 0){
                $exter = round($param['amount'] * $actPoint/100,2);
                $msg = "(另:活动期间已额外赠送您{$exter})";
                $data = [
                    'uid' =>$param['uid'],
                    'order_id'=>"",
                    'way'=>2,
                    'money'=>$param['amount'],
                    'give_money'=>$exter,
                    'o_desc'=>'人工订单活动赠送',
                    'inner_order_id'=>$info['orderCode'],
                    'o_status'=>2,
                    'op_name'=>'gm'
                ];
                $ret = DataUnionOrderModel::create($data);
                if(!$ret){
                    Log::info(__METHOD__.' 人工订单活动赠送 create order error ');
                }
            }

            $title = '人工充值成功提示';
            $content = "您人工充值的".$param['amount'].$msg."元已到账，请注意查收。";
            TmpPlatformMailRepository::sendEmail($param['uid'],$title,$content);
            return  $this->json('');
        }
        return  $this->json('',201,'系统错误');
    }

    /**
     * @param $name
     * @param $filter
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public static function getMongoDb($name,$filter){
        $manager = new \MongoDB\Driver\Manager(env('MONGOAPI'));
        $query   = new \MongoDB\Driver\Query($filter);
        return $manager->executeQuery($name, $query)->toArray();
    }



    /**
     * 导出excel
     * @param type $descList excel里面第一行
     * @param type $result 具体内容
     * @param type $title excel文件名
     */
    private function doExport($descList, $result, $title="execlLog") {
        $cellData = array_merge($descList, $result);
        Excel::create($title,function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
                $sheet->setWidth(['A' => 20, 'B' => 20, 'C' => 20, 'D' => 20, 'E' => 20, 'F' => 20, 'G' => 20, 'H' => 20]);
            });
        })->export('xls');
    }

    /**
     * vip充值 是否参与活动
     * @return int|mixed 活动赠送百分比
     */
    private static function _isVipActivity(){
        $actPoint = 0 ;
        $actInfo = SysActivityPayRepository::getActivePay();
        if($actInfo && isset($actInfo['act_info']['pay_ways'])){
            $payInfo = SysPayListsRepository::getActivePaysByType(SysPayListsModel::PAY_WAY_VIP);
            if($payInfo && in_array($payInfo->id,$actInfo['act_info']['pay_ways'])){
                $actPoint = floatval($actInfo['act_point']);
            }
        }
        return $actPoint;
    }
}
