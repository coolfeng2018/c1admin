<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\TmpDcusersModel;
use App\Models\TmpGameLogModel;
use function GuzzleHttp\Promise\queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class OperateRecordController extends Controller
{
    /**
     * 牌局记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sdate = date('Y-m-d', strtotime('-6 days'));
        $edate = date('Y-m-d',time());
        $tablelist = config('game.table_list');
        return view('admin.operate.record.index',['tableList' => $tablelist,'sdate'=>$sdate,'edate' => $edate]);
    }


    /**
     * 牌局记录数据请求接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $table_type = $request->get('channel',-1);
        $uid = $request->get('uid','');
        $limit = $request->get('limit',10);
        $sTime = $request->get('stime',date('Y-m-d',strtotime('-6 days')));
        $eTime = $request->get('etime',date('Y-m-d'));
        $sTime =strtotime($sTime);
        $eTime = strtotime($eTime)+86399;
        $tablelist = config('game.table_list');

        $Model = app(TmpGameLogModel::class);
        $data = $Model->getListData($table_type,$uid,$limit,$sTime,$eTime);

        $total = $data['total'];
        $data = $data['data'];
        foreach ($data as $key=>$val) {
            $data[$key]['table_type'] = $tablelist[$val['table_type']] ?? '';
            $data[$key]['begin_time'] = date('Y-m-d H:i:s',$val['begin_time']);
            $data[$key]['userNum']    = $val['all_user_count'] . "/" . ($val['all_user_count']-$val['true_user_count']);
            $data[$key]['winCount']   = -toRmb($val['system_win_sum']);
        }
        return $this->jsonTable($data,$total);
    }



    /**牌局记录详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request){
        $tableGid = $request->get('gid','');
        $etime = $request->get('etime','');
        $Model = app(TmpGameLogModel::class);
        $data = $Model->getDetailData($tableGid,$etime);
        $uidArr = [];
        foreach ($data as $key=>$v) {
            $uidArr[$key] = $v['uid'];
            $data[$key]['left_score'] = toRmb($v['left_score']);
            $data[$key]['add_score']  = toRmb($v['add_score']);
            $data[$key]['pay_fee']    = toRmb($v['pay_fee']);
            $data[$key]['before_score'] = round(toRmb($v['left_score'] - $v['add_score'] + $v['pay_fee']), 2);
        }
        $TmpDcusersModel = TmpDcusersModel::query();
        $rest  = $TmpDcusersModel->whereIn('uid',$uidArr)->pluck('nickname','uid');
        $userData = json_decode(json_encode($rest), true);
        foreach ($data as $k => $v){
            $data[$k]['nickname'] = $userData[$v['uid']] ?? '';
        }
        return view('admin.operate.record.detail',['data' => $data]);

    }



}
