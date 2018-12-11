<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/10/25 15:33
 * +------------------------------
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SysVipAvatarModel;
use App\Repositories\VipRepository;
use Illuminate\Http\Request;

/**
 * VIP头像框配置
 * Class AvatarController
 * @package App\Http\Controllers\Admin
 */
class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.avatar.index');
    }

    public function data(Request $request)
    {
        $model = SysVipAvatarModel::query();
//        if ($request->get('position_id')) {
//            $model = $model->where('position_id', $request->get('position_id'));
//        }
//        if ($request->get('title')) {
//            $model = $model->where('title', 'like', '%' . $request->get('title') . '%');
//        }
        $res = $model->orderBy('sort', 'desc')->orderBy('id', 'desc')
            ->paginate($request->get('limit', 30))
            ->toArray();

        return $this->jsonTable($res['data'], $res['total'], 0, '正在请求中...');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.avatar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'avator_id' => 'required|numeric',
            'time_type' => 'required|numeric',
            'use_time' => 'required|numeric',
            'condition' => 'required|string',
            'icon_border_url' => 'required|string',

//            'thumb' => 'required|string',
//            'position_id' => 'required|numeric'
        ]);
        if (SysVipAvatarModel::create($request->all())) {
            return redirect(route('admin.avatar'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.avatar'))->with(['status' => '系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advert = SysVipAvatarModel::findOrFail($id);

        return view('admin.avatar.edit', compact('advert'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'avator_id' => 'required|numeric',
            'time_type' => 'required|numeric',
            'use_time' => 'required|numeric',
            'condition' => 'required|string',
            'icon_border_url' => 'required|string',

//            'title' => 'required|string',
//            'sort' => 'required|numeric',
//            'thumb' => 'required|string',
//            'position_id' => 'required|numeric'
        ]);
        $advert = SysVipAvatarModel::findOrFail($id);
        if ($advert->update($request->all())) {
            return redirect(route('admin.avatar'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.avatar'))->withErrors(['status' => '系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return $this->json('', 1, '请选择删除项');
        }
        if (SysVipAvatarModel::destroy($ids)) {
            return $this->json('', 0, '删除成功');
        }
        return $this->json('', 1, '删除失败');
    }


    /**
     * 上线&&下线
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function online(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');

        if (SysVipAvatarModel::where(['id' => $id])->update(['online' => $status])) {
            return $this->json('', 1, '操作成功');
        }
        return $this->json('', 0, '系统错误');
    }

    /**
     * 上下移动
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');

        if (SysVipAvatarModel::where(['id' => $id])->update(['sort' => $status])) {
            return $this->json('', 1, '操作成功');
        }
        return $this->json('', 0, '系统错误');
    }

    /**
     * 置顶
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function top(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');

        if (SysVipAvatarModel::where(['id' => $id])->update(['is_top' => $status])) {
            return $this->json('', 1, '操作成功');
        }
        return $this->json('', 0, '系统错误');
    }

    /**
     * 发送配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {

        $flag = VipRepository::uploadAvatarConfig();

        if ($flag == VipRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}