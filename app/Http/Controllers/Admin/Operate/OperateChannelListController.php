<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\TmpChannelListModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OperateChannelListController extends Controller
{
    /**
     * 渠道管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.operate.channellist.index');
    }

    /**
     * data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $limit = $request->limit;
        $model = TmpChannelListModel::query()->where('status',1);
        $res  =  $model->paginate($limit)->toArray();
//        p($res);exit;
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.operate.channellist.create');
    }


    /**
     * 添加数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_time'] = time();
        if (TmpChannelListModel::create($data)){
            return $this->json('', 0, '添加完成');
        }
        return $this->json('', 1, '更新失败');
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $channelList = TmpChannelListModel::findOrFail($id);
        return view('admin.operate.channellist.edit',compact('channelList'));
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
        $data['modified_time'] = time();
        $channelList = TmpChannelListModel::findOrFail($id);
        if ($channelList->update($data)){
            return $this->json('', 0, '更新成功');
        }
        return $this->json('', 1, '更新失败');
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
        if (TmpChannelListModel::destroy($ids)){
            return $this->json('',0,'删除成功');
        }
        return $this->json('',1,'删除失败');
    }
}
