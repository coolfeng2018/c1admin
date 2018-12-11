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
use App\Models\SysNoticeModel;
use App\Repositories\NoticeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 系统广播
 * Class Beamed
 * @package App\Http\Controllers\Admin
 */
class NoticeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.notice.index');
    }

    public function data(Request $request)
    {
        $model = SysNoticeModel::query();

//        if ($request->get('position_id')) {
//            $model = $model->where('position_id', $request->get('position_id'));
//        }
//        if ($request->get('title')) {
//            $model = $model->where('title', 'like', '%' . $request->get('title') . '%');
//        }

        $res = $model->orderBy('id', 'desc')->paginate($request->get('limit', 20))->toArray();

//        dump($res['data']) ;
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

        return view('admin.notice.create');
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
            'info' => 'required|string',
            'interval' => 'required|numeric',
            'is_circul' => 'required|numeric',
            'play_start_time' => 'required|string',
            'play_end_time' => 'required|string'
        ]);

        if (SysNoticeModel::create($request->all())) {
            return redirect(route('admin.notice.index'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.notice.index'))->with(['status' => '系统错误']);
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
        $notice = SysNoticeModel::findOrFail($id);

        //所有广告位置
//        $positions = SysNoticeModel::orderBy('id', 'desc')->get();
//        foreach ($positions as $position) {
//            $position->selected = $position->id == $advert->position_id ? 'selected' : '';
//        }

        return view('admin.notice.edit', compact('notice'));
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
            'info' => 'required|string',
            'interval' => 'required|numeric',
            'is_circul' => 'required|numeric',
            'play_start_time' => 'required|string',
            'play_end_time' => 'required|string'
        ]);
        $notice = SysNoticeModel::findOrFail($id);
        if ($notice->update($request->all())) {
            return redirect(route('admin.notice.index'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.notice.index'))->withErrors(['status' => '系统错误']);
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
        if (SysNoticeModel::destroy($ids)) {
            return $this->json('', 1, '删除成功');
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

        $flag = NoticeRepository::uploadConfig();

        if ($flag == NoticeRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }


}