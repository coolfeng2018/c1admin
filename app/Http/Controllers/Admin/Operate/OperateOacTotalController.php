<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Repositories\DataTableOacRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperateOacTotalController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $configOac = config('game.oac_list');
        unset($configOac['6']);
        unset($configOac['15']);
        $oacListArr = json_encode($configOac,JSON_UNESCAPED_UNICODE);
        $prefix = DataTableOacRepository::$prefix;
        return view('admin.operate.oactotal.index',compact('oacListArr','prefix'));
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
        $list = DataTableOacRepository::getTableOacList($sdate,$edate);
        return $this->jsonTable($list,0,0,'正在请求中...');
    }
}
