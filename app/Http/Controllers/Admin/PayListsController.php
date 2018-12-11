<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysPayListsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayListsController extends Controller
{
    /**
     * 充值列表首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.paylists.index');
    }

    /**
     * 充值列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $payName = $request->get('pay_name','');
        $limit = $request->get('limit',30);
        $model = SysPayListsModel::query();
        if ($payName){
            $model->where('pay_name','like','%'.$payName.'%');
        }
        $res  =  $model->orderBy('o_status','desc')->orderBy('sort_id','asc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $payWaysArrs = SysPayListsModel::$payWaysArr;
        $diysArrs   = SysPayListsModel::$diysArr;
        $statusArrs = SysPayListsModel::$statusArr;
        $activitysArr = SysPayListsModel::$activitysArr;
        return view('admin.paylists.create',compact('payWaysArrs','diysArrs','statusArrs','activitysArr'));
    }

    /**
     * 参数验证
     * @param $request
     * @return array
     */
    private function _validate($request){
       $this->validate($request,[
            'pay_name'  => 'required|string',
            'pay_channel'  => 'required|string',
            'pay_way' => 'required|string',
            'money_list' => 'required|string',
            'is_diy' => 'required|numeric',
            'diy_max' => 'numeric',
            'diy_min' => 'numeric',
            'sort_id' => 'required|numeric',
            'pay_desc' => 'string',
            'o_status' => 'required|numeric',
            'o_activity' => 'required|numeric',
       ]);

        $data = $request->all();
        $data['op_name'] = Auth::user()->username;
        if($data['is_diy'] == SysPayListsModel::PAY_DIY_RECHARGE_NUM){
            $data['diy_max'] = intval($data['diy_max']);
            $data['diy_min'] = intval($data['diy_min']);
        }else{
            $data['diy_max'] = $data['diy_min'] = 0 ;
        }

        //vip充值
        if($data['pay_way'] == SysPayListsModel::PAY_WAY_VIP){
            $data['pay_name'] = SysPayListsModel::PAY_WAY_VIP_NAME;
            $data['pay_channel'] = SysPayListsModel::PAY_WAY_VIP_CHANNEL;
        }

        //银行卡转账
        $data['pay_info'] = [] ;
        if($data['pay_way'] == SysPayListsModel::PAY_WAY_UNIONCARD){
            $data['pay_info'] = [
                'rece_name'=> isset($data['rece_name'])? $data['rece_name'] :"",
                'rece_card_id'=> isset($data['rece_card_id'])?$data['rece_card_id']:"",
                'rece_bank_name'=> isset($data['rece_bank_name'])?$data['rece_bank_name']:"",
                'rece_bank_subname'=> isset($data['rece_bank_subname'])?$data['rece_bank_subname']:"",
                'rece_time_limit'=> isset($data['rece_time_limit'])?$data['rece_time_limit']:0,
            ];
        }else{
            $data['pay_info'] = [
                'rece_name'=> "",
                'rece_card_id'=> "",
                'rece_bank_name'=> "",
                'rece_bank_subname'=> "",
                'rece_time_limit'=> 0,
            ];
        }
        unset($data['rece_name'],$data['rece_card_id'],$data['rece_bank_name'],$data['rece_bank_subname'],$data['rece_time_limit']);
        return $data;
    }

    /**
     * 添加数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $this->_validate($request);
        if (SysPayListsModel::create($data)){
            return redirect(route('admin.paylists'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.paylists'))->with(['status'=>'系统错误']);
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $payInfo = SysPayListsModel::findOrFail($id);
        $payWaysArrs = SysPayListsModel::$payWaysArr;
        $diysArrs   = SysPayListsModel::$diysArr;
        $statusArrs = SysPayListsModel::$statusArr;
        $activitysArr = SysPayListsModel::$activitysArr;
        return view('admin.paylists.edit',compact('payInfo','payWaysArrs','diysArrs','statusArrs','activitysArr'));
    }

    /**
     * 单条数据更新
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $this->_validate($request);
        $payInfo = SysPayListsModel::findOrFail($id);
        if ($payInfo->update($data)){
            return redirect(route('admin.paylists'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.paylists'))->withErrors(['status'=>'更新失败']);
    }

    /**
     * 批量删除记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return $this->json('',1,'请选择删除项');
        }
        if (SysPayListsModel::destroy($ids)){
            return $this->json('',0,'删除成功');
        }
        return $this->json('',1,'删除失败');
    }
}
