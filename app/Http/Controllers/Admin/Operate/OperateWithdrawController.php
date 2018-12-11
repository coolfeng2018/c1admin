<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\WithdrawModel;
use App\Models\WithdrawRemarkModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OperateWithdrawController extends Controller
{
    /**
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $statusArr = WithdrawModel::$statusName;
        $statusArr[-1] = "全部";
        return view('admin.operate.withdraw.index',compact('statusArr'));
    }

    /**
     * 取现列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $uid = $request->get('uid',0);
        $status = $request->get('status',-1);
        $limit = $request->get('limit',30);
        $page = $request->get('page', 1);
        $model = WithdrawModel::query();

        if ($uid){
            $model->where('uid',$uid);
        }
        if($status >= 0 ){
            $model->where('Status',$status);
        }
        $res  =  $model->orderBy('Status','asc')
            ->orderBy('UpdateAt','desc')
            ->with('remark')
            ->paginate($limit)
            ->toArray();
        if (!empty($res['data']))
        {
            foreach ($res['data'] as &$item){
                $item['id'] = $item['WithdrawId'];
                $item['trueMoney'] = $item['Amount'] - $item['Fees'];
                $item['remark'] = $item['remark']['remark'];
                /*$paramUrl = [
                    'uid' => $item['uid'],
                    'status' => $item['Status'],
                    'withpage' => $page
                ];
                $item['url'] = route('admin.goldrecord',$paramUrl);*/
            }
        }
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request){
        $id = $request->get('ids',0);
        $remark = $request->get('desc','');
        $status = $request->get('type');

        $data = WithdrawModel::query()->where('WithdrawId',$id)->first();
        if(empty($data)){
            return $this->json('',1,'指定的记录不存在!!!');
        }
        if($data->Status != 0){
            return $this->json('',1,'非审核中记录不能操作!!!');
        }

        $temArray = [
            'Status' => $status,
            'UpdateAt' => date('Y-m-d H:i:s')
        ];
        $temArrayRemark = [
            'pid' => $id,
            'uid' => $data->uid,
            'remark' => $remark
        ];
        $ret = WithdrawModel::where('WithdrawId',$id)->update($temArray);
        if($ret){
            WithdrawRemarkModel::query()->insert($temArrayRemark);
            return $this->json('',0,'操作成功');
        }
        return $this->json('',1,'操作失败!!!');

    }


}
