<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\TmpCustomerModel;
use App\Models\TmpMessageModel;
use App\Repositories\TmpMessageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OperateCustomerController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $statusArr = TmpMessageModel::$reBackArr;
        $statusArr[-1] = "全部";
        return view('admin.operate.customer.index',compact('statusArr'));
    }

    /**
     * 列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $status = $request->get('status',-1);
        $uid = $request->get('uid',0);
        $page = $request->get('page',1);
        $limit = $request->get('limit',30);
        $messageRepository =  app(TmpMessageRepository::class);
        $result = $messageRepository->getList($uid,$status,$page,$limit);
        $total = $messageRepository->getTotle();
        return $this->jsonTable($result,$total,0,'正在请求中...');
    }

    /**
     * 详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request){
        $id = $request->get('id',0);
        $uid = $request->get('uid',0);
        $msgList = TmpMessageModel::query()->where('FromUid',$uid)->orWhere('ToUid',$uid)->orderBy('time','desc')->get()->toArray();
        $data = response(view('admin.operate.customer.details',compact('msgList','uid','id')))->getContent();
        return $data;
    }

    /**
     * 回复
     */
    public function reback(Request $request){
        $id = $request->get('id',0);
        $uid = $request->get('uid',0);
        $reback = $request->get('reback','');
        if(empty($reback) || empty($uid)){
            return $this->json('',1,'回复内容不能为空!!!');
        }
        $info = TmpMessageModel::query()->where('MessageId',$id)->first();
        if(empty($info)){
            return $this->json('',1,'指定回复的记录不存在!!!');
        }
        $time = date("Y-m-d H:i:s");

        DB::beginTransaction();
        $ret = TmpMessageModel::query()->where('MessageId',$id)->update(['reback'=>1,'time'=>$time]);
        if($ret){
            $res = TmpMessageModel::create([
                'ToUid'=>$uid,
                'FromUid'=>TmpMessageRepository::CUSTOMER_ID,
                'message'=>$reback,
            ]);
            if($res){
                $customer = TmpCustomerModel::query()->where('uid',$uid)->first();
                if($customer){
                    TmpCustomerModel::query()->where('uid',$uid)->update(['time'=>$time]);
                }else{
                    TmpCustomerModel::create(['uid'=>$uid,'time'=>$time]);
                }
                DB::commit();
                Redis::hdel(config('cacheKey.REDIS_CUSTOMER_FLAG'),$uid);
                return $this->json('',0,'回复成功,已经发送!!!');
            }
        }
        DB::rollBack();
        return $this->json('',1,'回复失败!!!');
    }

    /**
     * 音乐是否开启
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function play(Request $request)
    {
        $uid = $request->get('uid',0);
        $isReFash = $isOpen = false ;
        $key = config('cacheKey.REDIS_CUSTOMER_FLAG');
        if(Redis::exists($key)){
            $isOpen = true ;
        }else{
            app(TmpMessageRepository::class)->getList($uid);
            if(Redis::exists($key)){
                $isReFash = $isOpen = true ;
            }
        }
        return $this->json(['is_open'=>$isOpen,'is_refash'=>$isReFash]);
    }
}
