<?php

namespace App\Http\Controllers\Admin\Hall;


use App\Models\TmpChannelListModel;
use App\Models\TmpCreditModel;
use App\Models\TmpDcusersModel;
use App\Models\TmpPaymentOrderModel;
use App\Models\TmpUserLockModel;
use App\Models\TmpUserMoneyModel;
use App\Models\TmpUsersModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Log;


class UserListController extends Controller
{


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $model = TmpChannelListModel::query();
        $list = $model->select('code','name')->where('status',1)->get()->toArray();
        return view('admin.hall.userlist.index',['channel' => $list]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $phone   = $request->get('phone',0);
        $uid      = $request->get('uid',0);
        $dev      = $request->get('dev',0);
        $ip       = $request->get('ip','');
        $cid      = $request->get('cid','');
        $channel  = $request->get('channel','');
        $limit    = $request->get('limit',10);

        $model = TmpUsersModel::query();

        if ($phone){
            $model->where('phone',$phone);
        }
        if ($uid){
            $model->where('uid',$uid);
        }
        if ($dev){
            $model->where('dev',$dev);
        }
        if ($ip){
            $model->where('ip',$ip);
        }
        if ($cid){
            $model->where('cid',$cid);
        }
        if ($channel){
            $model->where('channel',$channel);
        }
        $model->orderBy('id','desc');
        $data = $model->paginate($limit)->toArray();
        $total = $data['total'];
        $data  = $data['data'];
        $arrId = [];
        foreach ($data as $key=>$val){
            $arrId[] = $val['uid'];
        }

        $model = TmpUserLockModel::query();
        $userLock = $model->select('uid')->where('lock_status',1)
            ->where('endtime','>',time())
            ->whereIn('uid',$arrId)->pluck('reason','uid')->toArray();
        $idLock = array_keys($userLock);
        $model = TmpCreditModel::query();
        $model->select('uid','account','Name','originBank','type')->whereIn('uid',$arrId);
        $rest = $model->where('Status',1)->get()->toArray();
        $list = [];
        foreach ($rest as $key => $val){
            if ($val['type'] == 0){
                $list[$val['uid']]['bank'] = '姓名:'.$val['Name'].'银行卡号:'.$val['account'].'开户行:'.$val['originBank'];
            }elseif ($val['type'] == 1){
                $list[$val['uid']]['pay'] = '姓名:'.$val['Name'].'支付宝账号:'.$val['account'];
            }

        }
        foreach($data as $key=>$val){
            $data[$key]['bankInfo'] = $list[$val['uid']]['bank'] ?? '';
            $data[$key]['payInfo'] = $list[$val['uid']]['pay'] ?? '';
            $data[$key]['is_lock']  = in_array($val['uid'],$idLock)?1:0;
        }
        return $this->jsonTable($data,$total);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        $uid = $request->get('uid',0);
        return view('admin.hall.userlist.create',['uid'=>$uid,'date'=>date('Y-m-d',time()+86400)]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $uid     = $request->get('uid',0);
        $desc    = $request->get('desc','');
        $endtime = $request->get('etime',date('Y-m-d',time()+86400));
        $endtime = strtotime($endtime);
        //发送服务器请求
        $param = array(
            'cmd'=>'forbidden',
            'uid'=>(int)$uid,
            'is_forbidden'=> true,
            'end_time'=>(int)$endtime,
            'reason'=>$desc
        );

        $rest = $this->_sendCurl($param);
        if($rest['code'] != 0) {
            return $this->json([],1,'服务器请求错误');
        }
        $data = array(
            'uid'       =>  $uid,
            'reason'    =>  $desc,
            'endtime'   =>  $endtime,
            'lock_status' =>  1,
            'op_name'   =>  Auth::user()->username,
            'op_time'   =>  time(),
        );

        $rest = TmpUserLockModel::query()->insert($data);
        if (!$rest){
            Log::info('user_lock:'.json_encode($data));
            return $this->json([],1,'添加失败');
        }

        return $this->json([],0,'添加成功');

    }


    /**
     * @param $data
     */
    private function _sendCurl($param){
        $url = config('server.server_api').'/gm';
        return BaseRepository::apiCurl($url,$param,'POST','www');
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancellock(Request $request){
        $uid = $request->get('uid',0);
        $param = array(
            'cmd'=>'forbidden',
            'uid'=>(int)$uid,
            'is_forbidden'=> false,
            'end_time'=>(int)time(),
            'reason'  =>'解除封号'
        );
        $rest = $this->_sendCurl($param);
        if($rest['code'] != 0) {
            return $this->json([],1,'服务器请求错误');
        }

        $data = ['lock_status'=>0,'op_time'=>time()];
        $rest = TmpUserLockModel::query()->where('uid',$uid)->update($data);
        if (!$rest){
            Log::info('user_lock:'.json_encode($data));
            return $this->json([],1,'添加失败');
        }

        return $this->json([],0,'添加成功');
    }



    /**
     * @param $name
     * @param $filter
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public static function getMongoDb($name,$filter){
        $manager = new \MongoDB\Driver\Manager(env('MONGOAPI'));
        $query   = new \MongoDB\Driver\Query($filter);
        return $manager->executeQuery($name, $query)->toArray();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request){
        $uid = $request->get('uid',0);

        $status = $request->get('status',0);
        $base  = self::getMongoDb('yange_data.base',['_id'=>(int)$uid]);
        $base  = $base[0] ?? [];
        $base = json_decode(json_encode($base),1);



        $users = self::getMongoDb('yange_data.users',['_id'=>(int)$uid]);
        $users = $users[0] ?? [];
        $users = json_decode(json_encode($users),1);
        $data  = array_merge($base,$users);
        $data['coins'] = isset($data['coins']) ? toRmb($data['coins']) : 0 ;
        $model    = TmpDcusersModel::query();
        $userData = $model->where('uid',$uid)->first()->toArray();

        if (empty($userData)){
            return view('admin.hall.gmcontrol.detail',['data'=>[]]);
        }

        $sum  = 'sum(if(reason=100028,value,0))/100 as deposit_sum,';   //充值
        $sum .=' sum(if(reason=100040,value,0))/100 as exch_sum,';      //兑换
        $sum .=' sum(if(reason=2,value,0))/100 as win_sum,';            //赢金币
        $sum .=' sum(if(reason=1,value,0))/100 as lose_sum,';           //输金币
        $sum .=' sum(if(reason=6,value,0))/100 as cost_sum';            //台费
        $model = TmpUserMoneyModel::query();
        $sumData = $model->select(DB::raw($sum))->where('uid',$uid)->first()->toArray();
        if (empty($sumData)){
            return view('admin.hall.gmcontrol.detail',['data'=>[]]);
        }
        $model = TmpPaymentOrderModel::query();
        $recharge_total = $model->where('uid',$uid)->where('status',2)->sum('amount');
        $recharge_total = toRmb($recharge_total ?? 0);                       //总充值

        $Creditdata = TmpCreditModel::query()->where('uid',$uid)->where('Status',1)->get()->toArray();
        $bank = $payData = [];
        foreach ($Creditdata as $key => $val){
            if ($val['type'] == 0){
                $payData['account'] = $val['account'];
                $payData['name']    = $val['Name'];
            }elseif ($val['type'] == 1){
                $bank['account'] = $val['account'];
                $bank['name']    = $val['Name'];
                $bank['addres']  = $val['originBank'].$val['originProvince'].$val['originCity'].$val['branchBank'];
            }
        }


        //总提现
        //$withdraw_total = TmpWidthdrawModel::query()->where('uid',$uid)->where('Status',1)->sum('Amount');

        $list = array(
            'uid'               =>  $uid,
            'nickname'          =>  $data['name'],
            'regist_time'       =>  date('Y-m-d H:i:s', $data['created_time']),           //注册时间
            'last_login_time'   =>  isset($data['last_login_time'])? date('Y-m-d H:i:s',$data['last_login_time']):'',       //最后登陆时间
            'phone'             =>  $userData['phone'] ?? '',                                    //手机号码
            'channel'           =>  $data['channel'] ?? '',                                          //渠道
            'sex'               =>  $data['sex']==1?'男':'女',                                  //性别
            'regist_ip'         =>  $userData['ip'],                                  //注册IP
            'login_ip'          =>  $this->getTaobaoAddress($data['last_login_ip']),           //登陆IP
            'device_id'         =>  $userData['device_id'],                                    //设备号
            'client_version'    =>  $userData['client_version'],                               //客户端

            'first_buy_time'    =>  $userData['first_buy_time'],                        //初次购买时间
            'coins'             =>  $data['coins'],                                     //金币数量
            'deposit_sum'       =>  $recharge_total,                                    //累计充值
            //'total_draw'        =>  $withdraw_total,                                        //总提现
            'exch_sum'          =>  $sumData['exch_sum'],                               //累计兑换
            'cost_sum'          =>  $sumData['cost_sum'],                               //累计扣台费
            'buycount'          =>  $userData['buycount'] ?? 0,                              //购买金额
            'win_sum'           =>  $sumData['win_sum'],                                    //累计赢金币
            'lose_sum'          =>  $sumData['lose_sum'],                                   //累计押注
            'head_img'          =>  config('server.file_upload_upload_url').'/'.$data['icon_border'],
            'payData'           =>  $payData,
            'bank'              =>  $bank,

        );

        $data = TmpUserLockModel::query()->where('uid',$uid)->get()->toArray();
        return view('admin.hall.userlist.detail',['list'=>$list,'data'=>$data,'status'=>$status]);

    }


    /**
     * @param string $ip
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTaobaoAddress($ip = ''){
        $address = '';
        $ip_content   = BaseRepository::curl("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip,'');
        $ip_arr = json_decode($ip_content,true);
        if(isset($ip_arr['code']) && $ip_arr['code'] == 0) {
            $address = $ip_arr['data']['region'].$ip_arr['data']['city'];
        }
        return $address;
    }




}
