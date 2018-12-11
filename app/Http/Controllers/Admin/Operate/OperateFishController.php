<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\TmpDcusersModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class OperateFishController extends Controller
{
    /**
     * 扑鱼记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sdate = date('Y-m-d', strtotime('-6 days'));
        $edate = date('Y-m-d',time());
        return view('admin.operate.fish.index',['sdate'=>$sdate,'edate' => $edate]);
    }

    /**
     * 扑鱼记录数据请求接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $usreName = $request->get('userName','');
        $uid = $request->get('uid','');
        $limit = $request->get('limit',10);
        $sTime = $request->get('stime',date('Y-m-d',strtotime('-6 days')));
        $eTime = $request->get('etime',date('Y-m-d'));
        $sTime = strtotime($sTime.' 00:00:00');
        $eTime = strtotime($eTime.' 23:59:59');

        $table = 'dc_log_fish.fish'.date('Ym', $sTime);
        $connectDatabase = config('constants.MYSQL_DATA_CENTER');

        $Model = DB::connection($connectDatabase)->table($table);
        if (!empty($uid)){
            $Model->where('uid','like',$uid);
        }
        if (! empty($usreName)) {
            $TmpDcusersModel = TmpDcusersModel::query();
            $nickname = trim($usreName);
            $rest  = $TmpDcusersModel->where('nickname','like',$nickname)->pluck('nickname','uid');
            $userData = json_decode(json_encode($rest), true);
            $uidArr = array_keys($userData);
            $Model->whereIn('uid',$uidArr);
        }

        $Model->whereBetween('create_time',[$sTime,$eTime]);
        $Model->select(DB::raw('uid,gid,sum(bullet_count) as bullet_count,sum(bullet_coins) as bullet_coins,sum(fish_count) as fish_count,sum(fish_coins) as fish_coins,create_time'));
        $Model->orderBy('create_time', 'desc');
        $Model->groupBy('uid');
        $data = $Model->paginate($limit);
        $data = json_decode(json_encode($data), true);
        $total = $data['total'];
        $data = $data['data'];
        $uidArr = [];
        foreach ($data as $key=>$val) {
            $data[$key]['bullet_coins'] = Number_format($val['bullet_coins']/100,2,'.','') .' (¥)';
            $data[$key]['fish_coins']   = Number_format($val['fish_coins']/100,2,'.','') .' (¥)';
            $data[$key]['create_time']  = date('Y-m-d H:i:s',$val['create_time']);
            $data[$key]['money']        = Number_format(($val['fish_coins']-$val['bullet_coins'])/100,2,'.','') .' (¥)';
            $uidArr[]                   = $val['uid'];
        }

        if (empty($usreName)) {
            $TmpDcusersModel = TmpDcusersModel::query();
            $rest  = $TmpDcusersModel->whereIn('uid',$uidArr)->pluck('nickname','uid');
            $userData = json_decode(json_encode($rest), true);
        }

        foreach ($data as $k => $v){
            $data[$k]['userName'] = @$userData[$v['uid']]?$userData[$v['uid']]:'';
        }


        return $this->jsonTable($data,$total);
    }

    /**
     * 扑鱼数据详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request){
        $uid = $request->get('uid','');
        $stime = $request->get('stime',date('Y-m-d',time()));
        $limit = $request->get('limit',10);
        $table = 'dc_log_fish.fish'.date('Ym', strtotime($stime));
        $connectDatabase = config('constants.MYSQL_DATA_CENTER');
        $Model = DB::connection($connectDatabase)->table($table);

        $Model->where('uid', $uid);
        $Model->select(DB::raw('create_date,sum(bullet_coins) as bullet_coins,sum(fish_coins) as fish_coins'));
        $Model->orderBy('create_time', 'desc');
        $Model->groupBy('create_date');
        $data = $Model->paginate($limit);
        $data = json_decode(json_encode($data), true);
        $total = $data['total'];
        $data = $data['data'];
        foreach ($data as $key=>$val) {
            $data[$key]['time']         = $val['create_date'];
            $data[$key]['bullet_coins'] = Number_format($val['bullet_coins'],2,'.','');
            $data[$key]['fish_coins']   = Number_format($val['fish_coins'],2,'.','');
            $data[$key]['money']        = Number_format(($val['fish_coins']-$val['bullet_coins'])/100,2,'.','') .' (¥)';
        }
        return view('admin.operate.fish.detail',['data'=>$data,'total'=>$total]);

    }



}
