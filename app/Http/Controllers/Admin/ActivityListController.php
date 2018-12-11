<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysActivityListModel;
use App\Repositories\ActivityRepository;
use App\Repositories\SysActivityListRepository;
use App\Traits\ActivityConfigTrait;
use App\Traits\ActivityValidateTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * 活动控制器
 * Class ActivityListController
 * @package App\Http\Controllers\Admin
 */
class ActivityListController extends Controller
{
    use ActivityConfigTrait,ActivityValidateTrait;
    /**
     * 充值活动首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.activity.list.index');
    }

    /**
     * 充值活动列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $actName = $request->get('act_name','');
        $limit = $request->get('limit',30);
        $model = SysActivityListModel::query();
        if ($actName){
            $model->where('act_name','like','%'.$actName.'%');
        }
        $res  =  $model->orderBy('updated_at','desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 活动类型变化
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(Request $request){
        $actID = $request->get('act_id',0);
        $actType = $request->get('act_type',1);
        $param = $request->all();
        $paramArr = $this->getActivityItemConfig($actType,ActivityRepository::class);
        $activityLists = [];
        if($actID > 0){
            $activityLists = SysActivityListModel::findOrFail($actID)->act_info;
        }
        $data = response(view('admin.activity.list.sub._subform_'.$actType,compact('activityLists','paramArr','param')))->getContent();
        return $this->json($data);
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $statusArrs = SysActivityListModel::$statusArr;
        $activesTypes = config('activity.activity_type_list');
        return view('admin.activity.list.create',compact('statusArrs','activesTypes'));
    }

    /**
     * 列表数据添加
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request)
    {
        $data = $this->_getData($request);
        if(!$data){
            return $this->json([],201,'数据验证不通过,请检查');
        }

        if (SysActivityListModel::create($data)){
            //发送服务器
           // $flag = SysActivityListRepository::postActivityDataToServer($actType,$data['act_info']);
            $flag = SysActivityListRepository::postAllActivityDataToServer();

            if ($flag == SysActivityListRepository::SUCCESS_FLAG) {
                return $this->json([],0,'活动添加成功,已推送服务器..');
            }

            return $this->json([],0,'活动添加成功');
        }
        return $this->json([],201,'活动添加失败');
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $activityLists = SysActivityListModel::findOrFail($id);
        $statusArrs = SysActivityListModel::$statusArr;
        $activesTypes = config('activity.activity_type_list');
        return view('admin.activity.list.edit',compact('activityLists','statusArrs','activesTypes'));
    }

    /**
     * 单条数据更新
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Request $request, $id)
    {
        $activityLists = SysActivityListModel::findOrFail($id);
        if(!$activityLists){
            return $this->json([],201);
        }
        $data = $this->_getData($request);
        if(!$data){
            return $this->json([],201,'数据验证不通过,请检查');
        }
        if ($activityLists->update($data)){
            //发送服务器
            //$flag = SysActivityListRepository::postActivityDataToServer($actType,$data['act_info']);
            $flag = SysActivityListRepository::postAllActivityDataToServer();
            if ($flag == SysActivityListRepository::SUCCESS_FLAG) {
                return $this->json([],0,'活动修改成功,已推送服务器..');
            }

            return $this->json([],0,'活动修改成功');
        }
        return $this->json([],201,'活动修改失败');
    }

    /**
     * 获取数据
     * @param $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    private function _getData($request){
        $actType = $request->get('act_type',1);
        $actName = $request->get('act_name','');
        $actCloseIntertval = $request->get('act_close_intertval',0);
        $status = $request->get('status',0);
        $startTime = $request->get('start_time',0);
        $endTime = $request->get('end_time',0);

        if(empty($actName) || empty($startTime) || empty($endTime)){
            return false;
        }

        $actInfo = $this->getActivityValidate($actType,$request->all());
        if(!$actInfo){
            return false;
        }

        $data = [];
        $data['act_name'] = $actName;
        $data['act_type'] = $actType;
        $data['act_close_intertval'] = $actCloseIntertval;
        $data['status'] = $status;
        $data['start_time'] = $startTime;
        $data['end_time'] = $endTime;
        $data['auth'] = Auth::user()->username;
        $data['act_info'] = $actInfo ;
        return $data ;
    }

    /**
     * 批量删除记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return $this->json('',1,'请选择删除项');
        }
        if (SysActivityListModel::destroy($ids)){
            return $this->json('',0,'删除成功');
        }
        return $this->json('',1,'删除失败');
    }

    /**
     * 批量发送活动配置到服务器
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(){
        $flag = SysActivityListRepository::postAllActivityDataToServer();
        if ($flag == SysActivityListRepository::SUCCESS_FLAG) {
            return $this->json([],0,'发送成功');
        }
        return $this->json([],201,'发送失败');
    }
}
