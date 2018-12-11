<?php

namespace App\Http\Controllers\Admin;


use App\Models\DataFishLogModel;
use App\Models\TmpDcusersModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FishRateController extends Controller
{

    protected $fishTable = 'data_fish_log';
    private static $config_filename = 'bet_list.lua';
    /**
     * 扑鱼记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sdate = date('Y-m-d', strtotime('-6 days'));
        $edate = date('Y-m-d',time());
        return view('admin.fishrate.index',['sdate'=>$sdate,'edate' => $edate]);
    }

    /**
     * 扑鱼记录数据请求接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $nickname = $request->get('nickname','');
        $uid = $request->get('uid','');
        $limit = $request->get('limit',10);
        //$sTime = $request->get('stime',date('Y-m-d',strtotime('-6 days')));
        //$eTime = $request->get('etime',date('Y-m-d'));
        //$sTime = strtotime($sTime.' 00:00:00');
        // $eTime = strtotime($eTime.' 23:59:59');
        $TmpDcusersModel = TmpDcusersModel::query();
        if (!empty($uid)){
            $TmpDcusersModel->where('uid',$uid);
        }
        if(!empty($nickname)){
            $TmpDcusersModel->where('nickname',trim($nickname));
        }
       // $TmpDcusersModel->whereBetween('modified_time',[$sTime,$eTime]);
        $TmpDcusersModel->orderBy('modified_time');
        $TmpDcusersModel ->select('uid','nickname');
        $data = $TmpDcusersModel->paginate($limit);
        $data = json_decode(json_encode($data), true);
        if (empty($data['total']) || empty($data['data'])){
            return $this->jsonTable([],0);
        }
        $total = $data['total'];
        $data  = $data['data'];
        $uidArr = [];
        foreach ($data as $val){
            $uidArr[] = $val['uid'];
        }
        $LogModel = DataFishLogModel::query(); // DB::table($this->fishTable);
        $LogModel->whereIn('uid',$uidArr);
        $logData = $LogModel->pluck('rate','uid');
        $list =[];
        foreach ($data as $key=>$val){
            $list[$key]['uid'] = $val['uid'];
            $list[$key]['nickname'] = $val['nickname'];
            $list[$key]['rate'] = @$logData[$val['uid']]?$logData[$val['uid']]:1;
        }
        return $this->jsonTable($list,$total);
    }

    /**
     * 扑鱼数据详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request){
        $uid   = $request->get('uid','');
        $limit = $request->get('limit',100);
        $Model =DataFishLogModel::query(); // DB::table($this->fishTable);
        $Model->where('uid', $uid);
        $Model->orderBy('created_at', 'desc');
        $data = $Model->get()->toArray();

        if (empty($data)){
            return view('admin.fishrate.detail',['data'=>$data]);
        }
        $TmpDcusersModel = TmpDcusersModel::query();
        $TmpDcusersModel->where('uid',$data[0]['uid']);
        $TmpDcusersModel ->select('nickname');
        $rest = $TmpDcusersModel->first();
        $nickname = $rest->nickname;

        foreach ($data as $key =>$val) {
            $data[$key]['nickname']  = $nickname;
        }
        return view('admin.fishrate.detail',['data'=>$data]);
    }



    /**
     *  单用户命中率页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request){
        $uid = $request->get('uid','');
        $nickname = $request->get('nickname','');
        $rate = $request->get('rate',1);
        return view('admin.fishrate.edit',['uid'=>$uid,'nickname'=>$nickname,'rate'=>$rate]);
    }

    /**
     * 用户命中率修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(Request $request){
        $uid = $request->get('uid','');
        $rate = $request->get('rate',1);
        $url = config('server.server_api').'/personal_control';
        $data = array(
            'uid'        => $uid,
            'rate'       => $rate,
            'op_name'    => Auth::user()->username,
            'created_at' => time(),
        );
        $Model =DataFishLogModel::query();   // DB::table($this->fishTable)->insert($data);
        DB::beginTransaction();
        $rest = $Model->insert($data);
        if (!$rest){
            DB::rollBack();
            return $this->json('',$rest['code'],'发送到服务器失败');
        }
        DB::commit();
        $params = array('cmd'=> 'fishrateset', 'uid'  => $uid, 'rate' => $rate);
        $rest = BaseRepository::apiCurl($url,$params,'POST','www');
        if ($rest['code'] != 0){
           DB::rollBack();
            return $this->json('',$rest['code'],'发送到服务器失败');
        }
        DB::commit();
        return $this->json('',0);

    }







}
