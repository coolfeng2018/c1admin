<?php

namespace App\Http\Controllers\Admin\Hall;


use App\Models\DataFishLogModel;
use App\Models\TmpDcusersModel;
use App\Models\TmpPlatformMailModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EmailController extends Controller
{

    protected $status = [
        1 => '已读',
        2 => '未读',
        3 => '已经领取',
        4 => '未领取',
        5 => '待发送',
    ];

    /**
     * 邮件
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.hall.email.index',['status'=>$this->status]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $range  = $request->get('range',0);
        $id     = $request->get('id',0);
        $limit  = $request->get('limit',10);
        $title  = $request->get('title','');
        $status = $request->get('status',0);
        $model = TmpPlatformMailModel::query();
        if ($range){
            $model->where('range',$range);
        }
        if ($id){
            $model->where('id',$id);
        }
        if ($title){
            $model->where('title',$title);
        }
        if ($status){
            switch ($status){
                case 1:
                    $status = 1;$read_state = 1; $coins=0; $receive_state = 0; break;
                case 2:
                    $status = 1;$read_state = 0; $coins=0; $receive_state = 0; break;
                case 3:
                    $status = 1;$read_state = 1; $coins=1; $receive_state = 1; break;
                case 4:
                    $status = 1;$read_state = 1; $coins=1; $receive_state = 0; break;
                case 5:
                    $status = 0;$read_state = 0; $receive_state = 0; break;
                default;
            }

            if ($status){
                $coins = $coins ? '>':'=';
                $model->where('coins',$coins,0);
            }
            $model->where(['status'=>$status,'read_state'=>$read_state,'receive_state'=>$receive_state]);
        }
        $model->where('op_user','<>','system');

        $model->orderBy('id','desc');
        $data = $model->paginate($limit)->toArray();
        if (empty($data['total']) || empty($data['data'])){
            return $this->jsonTable([],0);
        }
        $total = $data['total'];
        $data  = $data['data'];
        return $this->jsonTable($data, $total);
    }

    /**
     * 添加邮件
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('admin.hall.email.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'   => 'required|string',
            'content' => 'required|string',
            'range'   => 'required|string',
            'op_user' => 'required|string',
        ]);
        $title    = $request->get('title','');
        $content  = $request->get('content','');
        $range    = $request->get('range','');
        $op_user = $request->get('op_user','');
        $coins    = $request->get('coins',0);
        $range    = explode(',',trim(str_replace('，',',',$range),','));
        foreach ($range as $key=>$val){
            if (!is_numeric($val)){
                return $this->json([],'1','你输入正确ID类型');
            }
        }

        $data = [];
        foreach ($range as $key => $val) {
            $data[$key]['title']   = $title;
            $data[$key]['content'] = $content;
            $data[$key]['op_user'] = $op_user;
            $data[$key]['range']   = $val;
            $data[$key]['coins']   = $coins ?? 0;
        }
        DB::beginTransaction();

        try{
            $model = TmpPlatformMailModel::query();
            $rest = $model->insert($data);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return $this->json([],402,'添加邮件失败,请重试');
        }
        if (!$rest){
            return $this->json([],402,'添加邮件失败,请重试');
        }
        DB::commit();
        return $this->json([],0,'邮件添加成功');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request){
        $model = TmpPlatformMailModel::query();
        $data = $model->where('status',0)->get()->toArray();
        if (empty($data)){
            return $this->json([],0,'邮件发送成功');
        }

        $list  = [];
        $range = [];
        foreach ($data as $key=>$val){
            $list[] = ['id'=>$val['id'],'status'=>1];
            $range[] = $val['range'];
        }
        if (!self::sendEmail($range)){
            return $this->json([],1,'邮件发送失败！');
        }
        $arr = [];
        $model = TmpPlatformMailModel::query();
        foreach ($list as $key=>$val){
            $arr[] = $model->where('id',$val['id'])->update(['status'=>1]);
        }
        if(array_sum($arr)!= count($arr)){
            Log::info(json_encode($list));
        }
        return $this->json('',0,'发送成功');
    }

    /**
     * 发送接口
     * @param $range
     */
    public static function sendEmail($range){
        $url = config('server.server_mail_api_url');
        $param = [
            'cmd' => 'notifynewmail',
            'range' => $range,
            'mail_type' => 2
        ];
        $rest = BaseRepository::apiCurl($url, $param,'POST',$type='www');
        if ($rest['code'] == 0){
            return true;
        }
        return false;
    }

    public function update(Request $request){
        $this->validate($request, [
            'title'   => 'required|string',
            'content' => 'required|string',
            'range'   => 'required|string',
            'op_user' => 'required|string',
        ]);
        $id       = $request->get('id',0);
        $title    = $request->get('title','');
        $content  = $request->get('content','');
        $range    = $request->get('range','');
        $op_user  = $request->get('op_user','');
        $coins    = $request->get('coins',0);

        if (!is_numeric($id)){
            return $this->json([],'1','参数错误');
        }
        $model = TmpPlatformMailModel::query();
        $rest = $model->where('id',$id)->first()->toArray();

        $data = array(
            'title'   => $title,
            'content' => $content,
            'op_user' => $op_user,
            'coins'   => $coins,
            'status'  => 0,
            'read_state' => 0,
        );

        if ($rest['status'] == 1){
            if (!self::sendEmail($range)){
                return $this->json([],1,'修改失败,请重试！');
            }
        }

        DB::beginTransaction();
        try{
            $model = TmpPlatformMailModel::query();
            $update = $model->where('id',$id)->update($data);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return $this->json([],402,'修改失败,请重试');
        }
        if ($update){
            return $this->json([],0,'修改成功');
        }
        return $this->json([],1,'修改失败,请重试');

    }


    /**
     * 扑鱼数据详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request){
        $id = $request->get('id',0);
        $model = TmpPlatformMailModel::query();
        $data = $model->find($id)->toArray();
        return view('admin.hall.email.detail',['data'=>$data]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request){
        $id = $request->get('id',0);
        $model = TmpPlatformMailModel::query();
        $data = $model->find($id)->toArray();
        return view('admin.hall.email.edit',['data'=>$data]);
    }









}
