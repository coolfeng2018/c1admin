<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\DataUserHeadModel;
use App\Repositories\DataUserHeadRepository;
use App\Repositories\TmpPlatformMailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OperateUserHeadController extends Controller
{
    /**
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $statusArr = DataUserHeadModel::$oStatusArr;
        $statusArr[-1] = "全部";
        return view('admin.operate.userhead.index',compact('statusArr'));
    }

    /**
     * 列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $uid = $request->get('uid',0);
        $status = $request->get('status',-1);
        $limit = $request->get('limit',30);
        $model = DataUserHeadModel::query();
        if ($uid){
            $model->where('uid',$uid);
        }
        if($status >= 0 ){
            $model->where('o_status',$status);
        }
        $res  =  $model->orderBy('o_status','asc')->orderBy('updated_at','desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 通过
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request){
        $id = $request->get('id',0);
        $desc = $request->get('desc','');
        $info = DataUserHeadModel::findOrFail($id);
        if(empty($info)){
            return $this->json('',1,'指定玩家头像不存在!!!');
        }
        if($info->o_status != 0){
            return $this->json('',1,'非审核中头像不能操作!!!');
        }
        $ret = DataUserHeadModel::where('id',$id)
            ->update(['o_status'=>2,'op_name'=>Auth::user()->username,'o_desc'=>$desc]);
        if($ret){
            //更新头像 发送邮件
            if(DataUserHeadRepository::updateServerHead($info->uid,$info->head_url,$desc)){
                return $this->json('',0,'头像审核已通过,邮件已发送!!!');
            }
            return $this->json('',0,'头像审核已通过!!!');
        }
        return $this->json('',1,'头像审核,更新状态失败!!!');
    }

    /**
     * 批量拒绝记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refuse(Request $request)
    {
        $ids = $request->get('ids');
        $desc = $request->get('desc','');
        if (empty($ids)){
            return $this->json('',1,'请选择拒绝项');
        }
        $uid = 0;
        if(count($ids) == 1){
            $info = DataUserHeadModel::findOrFail(current($ids));
            if($info->o_status != 0){
                return $this->json('',1,'非审核中头像不能操作!!!');
            }
            $uid = $info->uid;
        }
        $ret = DataUserHeadModel::wherein('id',$ids)->update(['o_status'=>1,'op_name'=>Auth::user()->username,'o_desc'=>$desc]);
        if ($ret){
            //发送邮件通知
            $title = "头像更换审核";
            $content = empty($desc) ? "头像审核拒绝" : $desc;
            if(TmpPlatformMailRepository::sendEmail($uid,$title,$content)){
                return $this->json('',0,'已经成功拒绝,邮件已发送!!!');
            }
            return $this->json('',0,'已经成功拒绝');
        }
        return $this->json('',1,'拒绝失败');
    }
}
