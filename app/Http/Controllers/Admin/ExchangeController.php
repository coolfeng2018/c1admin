<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysUserExchangeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keep_money = SysUserExchangeModel::query()->value('keep_money');

        return view('admin.exchange.index', compact('keep_money'));
    }

    public function data(Request $request)
    {
        $model = SysUserExchangeModel::query();
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
        $methods = SysUserExchangeModel::$method;
        $exchange = [];
        return view('admin.exchange.create', compact('methods', 'exchange'));
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
            'method' => 'required|numeric',
            'min_money' => 'required|numeric',
            'max_money' => 'required|numeric|max:9999999.99',
            'status' => 'required|numeric',
            'thumb' => 'required|string',
        ]);
        if (SysUserExchangeModel::create($request->all())) {
            return redirect(route('admin.exchange'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.exchange'))->with(['status' => '系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exchange = SysUserExchangeModel::findOrFail($id);
        $methods = SysUserExchangeModel::$method;
        return view('admin.exchange.edit', compact('exchange', 'methods'));
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
            'method' => 'required|numeric',
            'min_money' => 'required|numeric',
            'max_money' => 'required|numeric|max:9999999.99',
            'status' => 'required|numeric',
//            'thumb' => 'required|string',
        ]);
        $SysUserExchangeModel = SysUserExchangeModel::findOrFail($id);
        if ($SysUserExchangeModel->update($request->all())) {
            return redirect(route('admin.exchange'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.exchange'))->withErrors(['status' => '系统错误']);
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
        if (SysUserExchangeModel::destroy($ids)) {
            return $this->json('', 0, '删除成功');
        }
        return $this->json('', 1, '删除失败');
    }

    /**
     * 上下线
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');

        if (SysUserExchangeModel::where(['id' => $id])->update(['status' => $status])) {
            return $this->json('', 1, '操作成功');
        }
        return $this->json('', 0, '系统错误');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMoney(Request $request)
    {
        $money = $request->post('money');

        if (SysUserExchangeModel::query()->update(['keep_money' => $money])) {
            return redirect(route('admin.exchange'))->with(['status' => '操作成功']);
        }
        return redirect(route('admin.exchange'))->with(['status' => '系统错误']);
    }


}
