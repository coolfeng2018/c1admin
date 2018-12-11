<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\12\5 0005
 * Time: 11:21
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SysErrorCodeModel;
use App\Repositories\ErrorCodeRepository;
use Illuminate\Http\Request;

/**
 * 错误码配置
 * Class ErrorCodeController
 * @package App\Http\Controllers\Admin
 */
class ErrorCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.errorcode.index');
    }

    public function data(Request $request)
    {
        $errorCode = $request->input('error_code','');
        $errorName = $request->input('error_name','');
        $model = SysErrorCodeModel::query();
        if($errorCode){
            $model->where(['error_code'=>$errorCode]);
        }
        if($errorName){
            $model->where('error_name','like','%'.$errorName.'%');
        }
        $res = $model->orderBy('error_code', 'asc')->paginate($request->get('limit', 30))->toArray();
        return $this->jsonTable($res['data'], $res['total'], 0, '正在请求中...');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.errorcode.create');
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
            'error_code' => 'required',
            'error_name' => 'required',
        ]);
        if (SysErrorCodeModel::create($request->all())) {
            return redirect(route('admin.errorcode'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.errorcode'))->with(['status' => '系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $errorCodeData = SysErrorCodeModel::findOrFail($id);
        return view('admin.errorcode.edit', [
            'errorCode' => $errorCodeData,
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
            'error_code' => 'required',
            'error_name' => 'required',
        ]);
        $advert = SysErrorCodeModel::findOrFail($id);
        if ($advert->update($request->all())) {
            return redirect(route('admin.errorcode'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.errorcode'))->withErrors(['status' => '系统错误']);
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
        if (SysErrorCodeModel::destroy($ids)) {
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
        $flag = ErrorCodeRepository::uploadErrorCodeConfig();

        if ($flag == ErrorCodeRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }
}