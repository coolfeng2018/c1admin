<?php

namespace App\Http\Controllers\Admin\Hall;
use App\Http\Controllers\Controller;
use App\Models\SysConfigModel;
use Illuminate\Http\Request;

class WeChatServiceController extends Controller{


    /**
     * 举报功能配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::WECHAT_SERVICE_CONFIG_KEY);
        return view('admin.hall.wechatservice.index',['data' => $data]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data= $request->get('data','');
        if (empty($data)){
            return $this->jsonTable('','', 1,'数据不能为空！');
        }
        $list = array();
        foreach ($data as  $key=>$val){
            foreach ($val as $k=>$v){
                $list[$key][$k] = $v ?? '';
            }
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::WECHAT_SERVICE_CONFIG_KEY, $list)) {
            return $this->jsonTable('','', 0,'保存成功!');
        }
        return $this->jsonTable('','', 1,'保存失败！');

    }



}
