<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Models\DataMessagesBoard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityMsssageController extends Controller
{
    /**
     * 留言列表首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.activity.message.index');
    }


    /**
     *  留言列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $limit = $request->get('limit',10);
        $model = DataMessagesBoard::query();
        $res  =  $model->orderBy('id','desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     *  留言板处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editStatus(Request $request)
    {
        $id = $request->get('id',0);
        $desc = $request->get('desc','');
        $messageData = DataMessagesBoard::findOrFail($id);
        if(!$messageData){
            return $this->json([],201,'处理失败..');
        }

        $data = [
            'status' => 2,
            'remarks' => $desc,
            'created_at' => time(),
        ];
        if ($messageData->update($data)){
            return $this->json([],0,'处理成功..');
        }
        return $this->json([],201,'处理失败..');
    }

    /**
     *  留言板批量处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editAll(Request $request)
    {
        $ids = $request->get('ids', 0);
        $desc = $request->get('desc','');
        if (empty($ids)){
            return $this->json('',201);
        }
        $data = [
            'status' => 2,
            'remarks' => $desc,
            'created_at' => time()
        ];
        $ret = DataMessagesBoard::query()->where('status',1)->whereIn('id', $ids)->update($data);
        if($ret){
            return $this->json([],0,'处理成功..');
        }
        return $this->json([],201,'处理失败..');
    }

    /**
     *  留言板删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll(Request $request)
    {
        $ids = $request->get('ids',0);
        if (empty($ids)){
            return $this->json([],201,'请选择删除项..');
        }
        if (DataMessagesBoard::destroy($ids)){
            return $this->json('',0,'删除成功');
        }
        return $this->json('',1,'删除失败');
    }
}
