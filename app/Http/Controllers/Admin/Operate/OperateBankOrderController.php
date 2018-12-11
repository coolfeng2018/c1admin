<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\DataUnionOrderModel;
use App\Models\SysPayListsModel;
use App\Repositories\DataUnionOrderRepository;
use App\Repositories\SysActivityPayRepository;
use App\Repositories\SysPayListsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OperateBankOrderController extends Controller
{
    /**
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $statusArr = DataUnionOrderModel::$oStatusArr;
        $statusArr[-1] = "全部";
        return view('admin.operate.bankorder.index',compact('statusArr'));
    }

    /**
     * 充值活动列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $uid = $request->get('uid',0);
        $status = $request->get('status',-1);
        $limit = $request->get('limit',30);
        $model = DataUnionOrderModel::query();
        if ($uid){
            $model->where('uid',$uid);
        }
        if($status >= 0 ){
            $model->where('o_status',$status);
        }
        $res  =  $model->orderBy('o_status','asc')->orderBy('updated_at','desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 通过并且发货
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request){
        $id = $request->get('id',0);
        $orderInfo = DataUnionOrderModel::findOrFail($id);
        if(empty($orderInfo)){
            return $this->json('',1,'指定的订单不存在!!!');
        }
        if($orderInfo->o_status != 0){
            return $this->json('',1,'非审核中订单不能操作!!!');
        }
        $actPoint = self::_isUnionActivity();
        $info = DataUnionOrderRepository::createOrder($orderInfo->uid,$orderInfo->money,$actPoint);
        if($info){
            $giveMoney = round(floatval($orderInfo->money*$actPoint/100),2);
            $ret = DataUnionOrderModel::where('id',$id)
                ->update(['o_status'=>3,'op_name'=>Auth::user()->username,'give_money'=>$giveMoney,'inner_order_id'=>$info['orderCode']]);
            if($ret){
                return $this->json('',0,'发货成功!!!');
            }
            return $this->json('',1,'发货成功,更新状态失败!!!');
        }else{
            return $this->json('',1,'发货失败!!!');
        }
    }

    /**
     * 银行卡转账 是否参与活动
     * @return int|mixed 活动赠送百分比
     */
    private static function _isUnionActivity(){
        $actPoint = 0 ;
        $actInfo = SysActivityPayRepository::getActivePay();
        if($actInfo && isset($actInfo['act_info']['pay_ways'])){
            $payInfo = SysPayListsRepository::getActivePaysByType(SysPayListsModel::PAY_WAY_UNIONCARD);
            if($payInfo && in_array($payInfo->id,$actInfo['act_info']['pay_ways'])){
                $actPoint = floatval($actInfo['act_point']);
            }
        }
        return $actPoint;
    }
    /**
     * 批量拒绝记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refuse(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return $this->json('',1,'请选择拒绝项');
        }
        if(count($ids) == 1){
            $orderInfo = DataUnionOrderModel::findOrFail(current($ids));
            if($orderInfo->o_status != 0){
                return $this->json('',1,'非审核中订单不能操作!!!');
            }
        }
        $ret = DataUnionOrderModel::wherein('id',$ids)->update(['o_status'=>1,'op_name'=>Auth::user()->username]);
        if ($ret){
            return $this->json('',0,'已经成功拒绝');
        }
        return $this->json('',1,'拒绝失败');
    }
}
