<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/18 18:40
 * +------------------------------
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SysBrodcastModel;
use App\Repositories\BrocastRepository;
use Illuminate\Http\Request;

/**
 * 系统广播
 * Class BroadcastController
 * @package App\Http\Controllers\Admin
 */
class BroadcastController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brodcast.index');
    }

    public function data(Request $request)
    {
        $model = SysBrodcastModel::query();

//        if ($request->get('position_id')) {
//            $model = $model->where('position_id', $request->get('position_id'));
//        }
//        if ($request->get('title')) {
//            $model = $model->where('title', 'like', '%' . $request->get('title') . '%');
//        }

        $res = $model->orderBy('id', 'desc')->paginate($request->get('limit', 20))->toArray();

        return $this->jsonTable($res['data'], $res['total'], 0, '正在请求中...');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //所有广告位置
//        $positions = Position::orderBy('sort', 'desc')->get();
//        return view('admin.notice.create', compact('positions'));

        return view('admin.brodcast.create', ['types' => SysBrodcastModel::$type]);
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
            'type' => 'required|numeric',
            'broad_name' => 'required|string',
            'info' => 'required|string',
            'exit_time' => 'required|numeric',
            'coins_range_min' => 'required|numeric',
            'coins_range_max' => 'required|numeric',
            'time_range_min' => 'required|numeric',
            'time_range_max' => 'required|numeric',
            'target_coins' => 'required|numeric',
        ]);

        if (SysBrodcastModel::create($request->all())) {
            return redirect(route('admin.brodcast.index'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.brodcast.index'))->with(['status' => '系统错误']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cast = SysBrodcastModel::findOrFail($id);

        //所有广告位置
//        $positions = SysNoticeModel::orderBy('id', 'desc')->get();
//        foreach ($positions as $position) {
//            $position->selected = $position->id == $advert->position_id ? 'selected' : '';
//        }

        return view('admin.brodcast.edit', [
            'cast' => $cast,
            'types' => SysBrodcastModel::$type,
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
            'type' => 'required|numeric',
            'broad_name' => 'required|string',
            'info' => 'required|string',
            'exit_time' => 'required|numeric',
            'coins_range_min' => 'required|numeric',
            'coins_range_max' => 'required|numeric',
            'time_range_min' => 'required|numeric',
            'time_range_max' => 'required|numeric',
            'target_coins' => 'required|numeric',
        ]);
        $cast = SysBrodcastModel::findOrFail($id);
        if ($cast->update($request->all())) {
            return redirect(route('admin.brodcast.index'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.brodcast.index'))->withErrors(['status' => '系统错误']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return $this->json('', 1, '请选择删除项');
        }
        if (SysBrodcastModel::destroy($ids)) {
            return $this->json('', 0, '删除成功');
        }
        return $this->json('', 1, '删除失败');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        $flag = BrocastRepository::uploadConfig();

        if ($flag == BrocastRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }


}