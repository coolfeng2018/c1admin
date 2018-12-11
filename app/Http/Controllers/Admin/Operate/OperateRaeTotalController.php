<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Repositories\TmpDatacenterRepository;
use App\Repositories\DataTableOacRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmpChannelListModel;

class OperateRaeTotalController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $configRae = config('game.oac_list');
        unset($configRae['6']);
        unset($configRae['15']);
        $raeListArr = json_encode($configRae,JSON_UNESCAPED_UNICODE);
        $prefix = DataTableOacRepository::$prefix;
        //获取渠道列表
        $channelList = app(TmpChannelListModel::class)->getChannel();
        return view('admin.operate.raetotal.index',compact('raeListArr','prefix', 'channelList'));
    }


    /**
     * 充值和兑换列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $sdate = strtotime($request->get('sdate',date("Y-m-d",strtotime("-10 day"))));
        $edate = strtotime($request->get('edate',date("Y-m-d")));
        $channel = $request->get('channel','all');
        //获取列表1
        $list = app(TmpDatacenterRepository::class)->getDataList($channel,$sdate,$edate);
        return $this->jsonTable($list['data'],$list['total'],0,'正在请求中...');
    }
}
