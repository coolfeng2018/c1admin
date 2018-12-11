<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysActivityPayModel;
use App\Repositories\SysPayListsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityPayController extends Controller
{
    /**
     * 充值活动首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.activity.pay.index');
    }

    /**
     * 充值活动列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $actName = $request->get('act_name','');
        $limit = $request->get('limit',30);
        $model = SysActivityPayModel::query();
        if ($actName){
            $model->where('act_name','like','%'.$actName.'%');
        }
        $res  =  $model->orderBy('updated_at','desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $statusArrs = SysActivityPayModel::$statusArr;
        $activesArrs = SysPayListsRepository::getActivePayLists();
        return view('admin.activity.pay.create',compact('statusArrs','activesArrs'));
    }

    /**
     * 参数验证
     * @param $request
     * @return array
     */
    private function _validate($request){
       return $this->validate($request,[
            'act_name'  => 'required|string',
            'act_key'  => 'required|string',
            'status'  => 'required|numeric',
            'act_point' => 'required|numeric',
            'act_mark' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'pay_ways' => 'required|array',
        ]);
    }

    /**
     * 列表数据获取
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->_validate($request);
        $data = $request->all();
        $data['auth'] = Auth::user()->username;
        $data['act_info'] = [
            'pay_ways'=>array_keys($data['pay_ways']),
        ];
        unset($data['pay_ways']);
        if (SysActivityPayModel::create($data)){
            return redirect(route('admin.activitypay'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.activitypay'))->with(['status'=>'系统错误']);
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $activityPays = SysActivityPayModel::findOrFail($id);
        $statusArrs = SysActivityPayModel::$statusArr;
        $activesArrs = SysPayListsRepository::getActivePayLists();
        return view('admin.activity.pay.edit',compact('activityPays','statusArrs','activesArrs'));
    }

    /**
     * 单条数据更新
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->_validate($request);
        $activityPays = SysActivityPayModel::findOrFail($id);
        $data = $request->all();
        $data['auth'] = Auth::user()->username;
        $data['act_info'] = [
            'pay_ways'=>array_keys($data['pay_ways']),
        ];
        unset($data['pay_ways'],$data['_method'],$data['_token'],$data['file']);
        if ($activityPays->update($data)){
            return redirect(route('admin.activitypay'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.activitypay'))->withErrors(['status'=>'更新失败']);
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
        if (SysActivityPayModel::destroy($ids)){
            return $this->json('',0,'删除成功');
        }
        return $this->json('',1,'删除失败');
    }
}
