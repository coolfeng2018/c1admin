<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SysConfigModel;
use Illuminate\Http\Request;

class ComplaintController extends Controller{


    protected static $list = [
        'complaint'     => '举报功能配置',
        'limit'         => '注册限制',
        ];


    /**
     * 举报功能配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list = self::$list;
        $complaint = SysConfigModel::getSysKeyExists(SysConfigModel::COMPLAINT_CONFIG_KEY);
        $limit    = SysConfigModel::getSysKeyExists(SysConfigModel::REGISTRAT_LIMIT_KEY);
        $data['wx']      = $complaint[0]['wx'] ?? '';
        $data['money']   = $complaint[0]['money'] ?? '';
        $data['ip_num']  = $limit['ip_num'] ?? '';
        $data['dev_num'] = $limit['dev_num'] ?? '';
        return view('admin.complaint.index',['data' => $data,'list'=>$list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data= $request->get('data','');
       // [{"wx":"xiaoxiao12","money":"3000"}]

        if (empty($data)){
            return $this->jsonTable('','', 1,'数据不能为空！');
        }
        $complaint[] = array(
            'wx'    =>  $data['wx'] ?? '',
            'money' =>  $data['money'] ?? '',
        );
        $limit = array(
            'ip_num'    =>  $data['ip_num'] ?? 0,
            'dev_num' =>  $data['dev_num'] ?? 0,
        );

        $limit     = SysConfigModel::saveSysVal(SysConfigModel::REGISTRAT_LIMIT_KEY, $limit);
        $complaint = SysConfigModel::saveSysVal(SysConfigModel::COMPLAINT_CONFIG_KEY, $complaint);

        if ($limit && $complaint) {
            return $this->jsonTable('','', 0,'保存成功!');
        }
        return $this->jsonTable('','', 1,'保存失败！');

    }



}
