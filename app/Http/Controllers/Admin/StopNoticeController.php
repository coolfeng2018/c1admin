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
use App\Models\SysStopNoticeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * 停服公告
 * Class Beamed
 * @package App\Http\Controllers\Admin
 */
class StopNoticeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.stopnotice.index');
    }

    public function data(Request $request)
    {
        $model = SysStopNoticeModel::query();
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
        return view('admin.stopnotice.create');
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
            'title' => 'required|string',
            'info' => 'required|string',
            'inscribe' => 'required|string',
            'notice_time' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string'
        ]);
        $username = Auth::user()->username;
        $data = $request->all();
        $data['redactor'] = $username;
        if (SysStopNoticeModel::create($data)) {
            return redirect(route('admin.stopnotice.index'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.stopnotice.index'))->with(['status' => '系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stopnotice = SysStopNoticeModel::findOrFail($id);
        return view('admin.stopnotice.edit', compact('stopnotice'));
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
            'title' => 'required|string',
            'info' => 'required|string',
            'inscribe' => 'required|string',
            'notice_time' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string'
        ]);
        $username = Auth::user()->username;
        $data = $request->all();
        $data['redactor'] = $username;

        $notice = SysStopNoticeModel::findOrFail($id);
        if ($notice->update($data)) {
            return redirect(route('admin.stopnotice.index'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.stopnotice.index'))->withErrors(['status' => '系统错误']);
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
        if (SysStopNoticeModel::destroy($ids)) {
            return $this->json('', 1, '删除成功');
        }
        return $this->json('', 1, '删除失败');
    }
}