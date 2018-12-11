<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Repositories\DataTableFeeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperateTableFeeController extends Controller
{
    /**
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tableListArr = json_encode(config('game.table_list'),JSON_UNESCAPED_UNICODE);
        $prefix = DataTableFeeRepository::$prefix;
        return view('admin.operate.tablefee.index',compact('tableListArr','prefix'));
    }


    /**
     * 台费列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $sdate = $request->get('sdate',date("Y-m-d",strtotime("-1 day")));
        $edate = $request->get('edate',date("Y-m-d"));
        $list = DataTableFeeRepository::getTableFeeList($sdate,$edate);
        return $this->jsonTable($list,0,0,'正在请求中...');
    }
}
