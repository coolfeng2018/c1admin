<?php

namespace App\Http\Controllers\Admin\Operate;


use App\Repositories\TmpStoreRresultRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 库存
 * Class OperateStockController
 * @package App\Http\Controllers\Admin\Operate
 */
class OperateStockController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tableListArr = json_encode(config('game.robot_type_list'),JSON_UNESCAPED_UNICODE);
        $prefix = TmpStoreRresultRepository::$prefix;
        return view('admin.operate.stock.index',compact('tableListArr','prefix'));
    }


    /**
     * 库存列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $sdate = $request->get('sdate',date("Y-m-d",strtotime("-1 day")));
        $edate = $request->get('edate',date("Y-m-d"));
        $list = TmpStoreRresultRepository::getTableFeeList($sdate,$edate);
        return $this->jsonTable($list,0,0,'正在请求中...');
    }
}
