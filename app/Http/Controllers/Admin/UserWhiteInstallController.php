<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserWhiteListModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserWhiteInstallController extends Controller
{
    /**
     * 白名单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.whiteinstall.index');
    }

    /**
     * 白名单列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $address = $request->get('address','');
        $limit = $request->get('limit',10);
        $model = UserWhiteListModel::query();
        $model->where('type',2);
        if ($address){
            $model->where('address',$address);
        }
        $res  =  $model->orderBy('id','desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.whiteinstall.create');
    }


    /**
     * 添加数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['type'] = 2;
        $data['auth'] = Auth::user()->username;
        if (UserWhiteListModel::create($data)){
            return redirect(route('admin.whiteinstall'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.whiteinstall'))->with(['status'=>'系统错误']);
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $payInfo = UserWhiteListModel::findOrFail($id);
        return view('admin.whiteinstall.edit',compact('payInfo'));
    }

    /**
     * 单条数据更新
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['type'] = 2;
        $data['auth'] = Auth::user()->username;
        $payInfo = UserWhiteListModel::findOrFail($id);
        if ($payInfo->update($data)){
            return redirect(route('admin.whiteinstall'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.whiteinstall'))->withErrors(['status'=>'更新失败']);
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
        if (UserWhiteListModel::destroy($ids)){
            return $this->json('',0,'删除成功');
        }
        return $this->json('',1,'删除失败');
    }
}
