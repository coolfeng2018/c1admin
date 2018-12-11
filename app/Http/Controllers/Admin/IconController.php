<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysActIconModel;
use App\Models\SysActivityListModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 活动Icon排序配置
 * Class GameController
 * @package App\Http\Controllers\Admin
 */
class IconController extends Controller
{
    /**
     * 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.icon.index');
    }

    /**
     * 列表数据获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $limit = $request->get('limit', 10);
        $res = SysActIconModel::query()
            ->orderBy('sort_id', 'asc')
            ->paginate($limit)
            ->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $name = SysActIconModel::$name;
        $time = time();
        //获取活动列表
        $activityData = SysActivityListModel::query()
            ->select('id','act_name')
            ->where([['start_time','<',$time],['end_time','>',$time]])
            ->orderBy('id','asc')
            ->get()->toArray();

        return view('admin.icon.create',compact('name','activityData'));
    }

    /**
     * 添加操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = [
            'sort_id' => $request->get('sort_id',''),
            'key_id' => $request->get('key_id',''),
            'name_id' => $request->get('name_id',''),
            'auth' => Auth::user()->username
        ];
        if (SysActIconModel::query()->insert($data)) {
            return redirect(route('admin.icon'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.icon'))->with(['status' => '系统错误']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $icon = SysActIconModel::findOrFail($id);

        $name = SysActIconModel::$name;
        $time = time();
        //获取活动列表
        $activityData = SysActivityListModel::query()
            ->select('id','act_name')
            ->where([['start_time','<',$time],['end_time','>',$time]])
            ->orderBy('id','asc')
            ->get()->toArray();

        return view('admin.icon.edit', compact('icon','name','activityData'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $iconData = SysActIconModel::findOrFail($id);
        $data = [
            'sort_id' => $request->get('sort_id',''),
            'key_id' => $request->get('key_id',''),
            'name_id' => $request->get('name_id',''),
            'auth' => Auth::user()->username
        ];
        if ($iconData->update($data)) {
            return redirect(route('admin.icon'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.icon'))->withErrors(['status' => '系统错误']);
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return $this->json('', 1, '请选择删除项');
        }
        if (SysActIconModel::destroy($ids)) {
            return $this->json('', 0, '删除成功');
        }
        return $this->json('', 1, '删除失败');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(Request $request)
    {
        $type = $request->get('type','');
        $id = $request->get('id','');
        if (empty($type) || empty($id))
        {
            return $this->json('', 1, '参数有误');
        }
        $iconData = SysActIconModel::findOrFail($id);

        $sort_id = $type == 1 ? $iconData->sort_id-1 : $iconData->sort_id+1;
        $iconObj = SysActIconModel::query()->where(['sort_id'=>$sort_id])->get()->toArray();
        if (empty($iconObj))
        {
            return $this->json('', 1, '系统错误');
        }
        $sql = "UPDATE sys_act_icon c JOIN sys_act_icon cc ON (c.id = {$id} AND cc.id = {$iconObj[0]['id']}) SET c.sort_id = cc.sort_id , cc.sort_id = c.sort_id";

        if (DB::update($sql))
        {
            return $this->json('', 0, '移动成功');
        }
        return $this->json('', 1, '系统错误');
    }

}
