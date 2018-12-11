<?php

namespace App\Http\Controllers\Admin\Hall;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\DataPackageModel;
use App\Models\SysConfigModel;
use App\Models\TmpItemModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class NewAwardController extends Controller{


    /**
     * 新人奖励配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::NEWBIE_AWARD_CONFIG_KEY);
        $data = $data ?? [];
       // $package = DataPackageModel::query()->orderBy('id','asc')->pluck('name','prop_id');
        $package = TmpItemModel::query()->orderBy('id','asc')->pluck('name','id');
        return view('admin.hall.newaward.index',['list'=>$package,'data'=>$data]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
       // $msg  = $request->get('msg','');
        $data  = json_decode($data);
        if (empty($data)){
            return $this->json([], 1,'数据不能为空！');
        }
        $temp = array();
        foreach ($data as  $key=>$val){
            $temp[$key]['item_id'] = $val[0];
            $temp[$key]['count']   = $val[1];
        }
        //$list['newbie_state'] = $msg;
        //$list['award_list']   = $temp;
        if (SysConfigModel::saveSysVal(SysConfigModel::NEWBIE_AWARD_CONFIG_KEY, $temp)) {
            return $this->json([], 0,'保存成功!');
        }
        return $this->json([], 1,'保存失败！');
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(){
        $data   = SysConfigModel::getSysKeyExists(SysConfigModel::NEWBIE_AWARD_CONFIG_KEY);
        if (empty($data)){
            return $this->json([], 1, '数据未填写');
        }
        foreach ($data as $key=>$val){
            $data[$key]['count'] = toMinute($val['count']);
        }
        $params = [SysConfigModel::NEWBIE_AWARD_CONFIG_KEY => Covert::arrayToLuaStr($data)];
        $flag = BaseRepository::apiCurl(config('server.upload_config_url'), $params,'POST','www');
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json([], 0, '发送配置成功');
        } else {
            return $this->json([], 1, '发送配置失败');
        }

    }



}
