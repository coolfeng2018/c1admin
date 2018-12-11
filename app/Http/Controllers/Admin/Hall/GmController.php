<?php

namespace App\Http\Controllers\Admin\Hall;



use App\Models\TmpUserStockLogModel;
use App\Models\TmpUserStockModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Log;


class GmController extends Controller
{

    protected   $status = [
        0 => '中止',
        1 => '执行中'
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $status = $this->status;
        return view('admin.hall.gmcontrol.index',['status' => $status]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $status   = $request->get('status','-1');
        $uid      = $request->get('uid',0);
        $limit    = $request->get('limit',10);

        $model = TmpUserStockModel::query();
        if ($uid){
            $model->where('uid',$uid);
        }
        if ($status != -1){
            $model->where('curr_status',$status);
        }
        $model->orderBy('create_at','desc');
        $data = $model->paginate($limit)->toArray();
        $total = $data['total'];
        $data  = $data['data'];
        $arrId = [];
        foreach ($data as $key=>$val){
            $arrId[] = $val['uid'];
        }
        $list = self::getCurrData(implode(',',$arrId));
        foreach ($data as $key => $val){
            $data[$key]['name']   = $list[$val['uid']]['name'];
            $data[$key]['curr_control_weight'] = $list[$val['uid']]['curr_control_weight'];
            $data[$key]['curr_control_status'] = $this->status[$list[$val['uid']]['curr_control_status']];
            $data[$key]['curr_control_coins']  = toRmb($list[$val['uid']]['curr_control_coins']);
            $data[$key]['init_control_coins']  = toRmb($list[$val['uid']]['init_control_coins']);
        }
        return $this->jsonTable($data,$total);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('admin.hall.gmcontrol.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'uid'             => 'required|string',
            'weights'         => 'required|string',
            'amount'          => 'required|string',
        ]);
        $uid     = $request->get('uid','');
        $weights = $request->get('weights','');
        $amount  = $request->get('amount','');

        $model = TmpUserStockModel::query();
        $rest = $model->where('uid',$uid)->first();
        if ($rest){
            return $this->json([],1,'ID已经存在');
        }
        $url = config('server.server_api').'/personal_control';
        $param = [
            'cmd' => 'webadddata',
            'uid' => (int)$uid,
            'init_control_coins'  => $amount*100,
            'init_control_weight' => (int)$weights
        ];

        $data = json_encode($param);
        $rest = BaseRepository::curl($url,$data);


        $rest = json_decode($rest,1);
        if(empty($rest) || $rest['code']!= 0){
           return $this->json([],402,'服务端接口请求失败!');
        }
        DB::beginTransaction();
        try{
            $data = [
                'uid'               => $uid,
                'weights'           => $weights,
                'control_amount'    => $amount,
                'creation_type'     => '手动添加',
                'create_at'         => time(),
                'editor'            => Auth::user()->username,
                'curr_status'       =>  $rest['data']['curr_status'],
            ];
            $model = TmpUserStockModel::query();
            $inst = $model->insert($data);
            //变化日志
            $insert['uid'] = $uid;
            $insert['create_at']                 = time();
            $insert['creation_type']             = '手动添加';
            $insert['before_personal_inventory'] = $rest['data']['pre_control_coins'];
            $insert['after_personal_inventory']  = $rest['data']['curr_control_coins'];
            $insert['change_personal_inventory'] = $rest['data']['curr_control_coins']-$rest['data']['pre_control_coins'];
            $insert['before_weights']            = $rest['data']['pre_control_weight'];
            $insert['after_weights']             = $rest['data']['curr_control_weight'];

            $model = TmpUserStockLogModel::query();
            $inst1 = $model->insert($insert);
            if (!$inst || !$inst1){
                Log::info('user_stock'.json_encode($data));
                Log::info('user_stock_log'.json_encode($insert));
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::info('user_stock'.json_encode($data));
            Log::info('user_stock_log'.json_encode($insert));
            return $this->json([],402,'数据写入失败');
        }

        return $this->json([],0,'添加成功');


    }




    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request){
        $uid = $request->get('uid',0);
        $limit = $request->get('limit',10);
        $model = TmpUserStockLogModel::query();
        $data = $model->where('uid',$uid)->get()->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['create_at']  = date('Y-m-d H:i:s',$value['create_at']);
            $data[$key]['before_personal_inventory'] = toRmb($value['before_personal_inventory']);
            $data[$key]['after_personal_inventory']  = toRmb($value['after_personal_inventory']);
            $data[$key]['change_personal_inventory'] = toRmb($value['change_personal_inventory']);
        }
        return view('admin.hall.gmcontrol.detail',['data'=>$data]);
    }




    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request){
        $uid = $request->get('uid','');
        $model = TmpUserStockModel::query();
        $data = $model->where('uid',$uid)->first()->toArray();
        return view('admin.hall.gmcontrol.edit',['uid'=>$uid,'data'=>$data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(Request $request){
        $uid     = $request->get('uid',0);
        $weights = $request->get('weights',0);
        $amount  = $request->get('amount',0);
        $uid = (int)$uid;
        $weights = (int)$weights;
        $url = config('server.server_api').'/personal_control';
        $param = [
            'cmd' => 'webadddata',
            'uid' => $uid,
            'init_control_coins'  => $amount*100,
            'init_control_weight' => $weights
        ];
        $data = json_encode($param);
        $rest = BaseRepository::curl($url,$data);

        $rest = json_decode($rest,1);
        if(empty($rest) || $rest['code']!= 0){
            return $this->json([],402,'服务端接口请求失败!');
        }

        $data = array(
            'weights'           => $weights,
            'control_amount'    => $amount,
            'creation_type'     => '手动添加',
            'create_at'         => time(),
            'editor'            => Auth::user()->username,
            'curr_status'       =>  $rest['data']['curr_status'],
        );


        $model = TmpUserStockModel::query();
        $inst = $model->where('uid','=',$uid)->update($data);
            //变化日志
            $insert['uid'] = $uid;
            $insert['create_at']                 = time();
            $insert['creation_type']             = '手动添加';
            $insert['before_personal_inventory'] = $rest['data']['pre_control_coins'];
            $insert['after_personal_inventory']  = $rest['data']['curr_control_coins'];
            $insert['change_personal_inventory'] = $rest['data']['curr_control_coins']-$rest['data']['pre_control_coins'];
            $insert['before_weights']            = $rest['data']['pre_control_weight'];
            $insert['after_weights']             = $rest['data']['curr_control_weight'];

            $model = TmpUserStockLogModel::query();
            $inst1 = $model->insert($insert);

        if (!$inst || !$inst1){
            Log::info('user_stock'.json_encode($data));
            Log::info('user_stock_log'.json_encode($insert));
        }

        return $this->json([],0,'添加成功');


    }


    /**
     * 获取实时数据
     * @param string $uid
     * @return array
     */
    public static function getCurrData($uid = ''){
        if (empty($uid)){
            return [];
        }
        $url = config('server.server_api').'/personal_control';
        $param = ['cmd' => 'webgetdata', 'uid_list' => $uid];
        $data = BaseRepository::apiCurl($url, $param,'POST',$type='www');
        if ($data['code'] == 0){
            $list= [];
            foreach ($data['data_list'] as $key=>$val){
                $list[$val['uid']] = $val;
            }
            return $list;
        }
        return [];
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request){
        $uid    = $request->get('uid',0);
        $status = $request->get('status','-1');
        $url = config('server.server_api').'/personal_control';

        if ($status == -1){
            return $this->json([],1,'参数错误');
        }
        $status = $status ? 0:1;
        $param = [
            'cmd' => 'webswitch',
            'uid' => $uid,
            'status' => $status
        ];

        $data = json_encode($param);
        $rest = BaseRepository::curl($url,$data);
        $rest = json_decode($rest,1);


        if(empty($rest) || $rest['code']!= 0){
            return $this->json([],402,'服务端接口请求失败!');
        }
        $model  = TmpUserStockModel::query();
        $rest   = $model->where('uid',$uid)->update(['curr_status'=>$status]);
        Log:info('user_stock'.json_encode(array('uid'=>$uid,'status'=>$status)));
        return $this->json([],0,'更改成功');

    }


}
