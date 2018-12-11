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
use App\Models\SysVipModel;
use App\Repositories\VipRepository;
use Illuminate\Http\Request;

/**
 * VIP配置
 * Class VipController
 * @package App\Http\Controllers\Admin
 */
class VipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.vip.index');
    }

    public function data(Request $request)
    {
        $model = SysVipModel::query();
//        if ($request->get('position_id')){
//            $model = $model->where('position_id',$request->get('position_id'));
//        }
//        if ($request->get('title')){
//            $model = $model->where('title','like','%'.$request->get('title').'%');
//        }
        $res = $model->orderBy('id', 'desc')->paginate($request->get('limit', 30))->toArray();
        return $this->jsonTable($res['data'], $res['total'], 0, '正在请求中...');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vip.create', ['privilege' => SysVipModel::$privilege]);
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
            'level' => 'required|numeric',
            'charge_coins' => 'required|numeric',
            'week_award_max' => 'required|numeric',
            'icon_border_url' => 'required|string',
            'battery_url' => 'required|string',
        ]);

        $params = $request->all();
        if (isset($params['enter_word'])) {
            $params['enter_word'] = $params['enter_word'] ?? '';
        }

        if (SysVipModel::create($params)) {
            return redirect(route('admin.vip'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.vip'))->with(['status' => '系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advert = SysVipModel::findOrFail($id);

        return view('admin.vip.edit', [
            'advert' => $advert,
            'privilege' => SysVipModel::$privilege
        ]);
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
            'level' => 'required|numeric',
            'charge_coins' => 'required|numeric',
            'week_award_max' => 'required|numeric',
            'icon_border_url' => 'required|string',
            'battery_url' => 'required|string',
        ]);

        $params = $request->all();
        if (isset($params['enter_word'])) {
            $params['enter_word'] = $params['enter_word'] ?? '';
        }

        $advert = SysVipModel::findOrFail($id);
        if ($advert->update($params)) {
            return redirect(route('admin.vip'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.vip'))->withErrors(['status' => '系统错误']);
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
        if (SysVipModel::destroy($ids)) {
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

        if (SysVipModel::where(['id' => $id])->update(['online' => $status])) {
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

        $flag = VipRepository::uploadVipConfig();

        if ($flag == VipRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}