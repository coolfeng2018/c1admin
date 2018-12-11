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
use App\Models\SysConfigModel;
use App\Models\SysVipRobotModel;
use App\Repositories\VipRepository;
use Illuminate\Http\Request;

/**
 * VIP机器人配置
 * Class RobotController
 * @package App\Http\Controllers\Admin
 */
class RobotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.robot.index');
    }

    public function data(Request $request)
    {
        $model = SysVipRobotModel::query();
//        if ($request->get('position_id')) {
//            $model = $model->where('position_id', $request->get('position_id'));
//        }
//        if ($request->get('title')) {
//            $model = $model->where('title', 'like', '%' . $request->get('title') . '%');
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
        return view('admin.robot.create', ['rate' => SysVipRobotModel::$vip_rate]);
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
//            'title' => 'required|string',

            'min_coins' => 'required|numeric',
            'max_coins' => 'required|numeric',

//            'thumb' => 'required|string',
//            'position_id' => 'required|numeric'
        ]);
        if (SysVipRobotModel::create($request->all())) {
            return redirect(route('admin.robot'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.robot'))->with(['status' => '系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advert = SysVipRobotModel::findOrFail($id);

        return view('admin.robot.edit', [
            'advert' => $advert,
            'rate' => SysVipRobotModel::$vip_rate
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
            'min_coins' => 'required|numeric',
            'max_coins' => 'required|numeric',

        ]);
        $advert = SysVipRobotModel::findOrFail($id);
        if ($advert->update($request->all())) {
            return redirect(route('admin.robot'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.robot'))->withErrors(['status' => '系统错误']);
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
        if (SysVipRobotModel::destroy($ids)) {
            return $this->json('', 0, '删除成功');
        }
        return $this->json('', 1, '删除失败');
    }


    /**
     * 发送配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {

        $flag = VipRepository::uploadVipRobotConfig();

        if ($flag == VipRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

    /**
     *  机器人随机概率设置
     */
    public function rank(Request $request)
    {
        if ($request->isMethod('POST')) {
            if (SysConfigModel::saveSysVal(SysConfigModel::ROBOT_RANK_VIP_KEY, $request->all())) {
                return redirect(route('admin.robot.rank'))->with(['status' => '更新成功']);
            }
            return redirect(route('admin.robot.rank'))->withErrors(['status' => '系统错误']);
        } else {

            $config = SysConfigModel::getSysKeyExists(SysConfigModel::ROBOT_RANK_VIP_KEY);

            return view('admin.robot.rank', [
                'rate' => SysVipRobotModel::$vip_rate,
                'config' => $config
            ]);
        }
    }

    /**
     * 发送配置
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRank()
    {

        $flag = VipRepository::uploadRobotRankConfig();

        if ($flag == VipRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}