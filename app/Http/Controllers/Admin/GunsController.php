<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class GunsController extends Controller{


    /**
     * vip炮台配置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_GUNS_KEY);
        return view('admin.guns.index',['data' => $data]);
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
        foreach ($data as $key=>$val){
            $data[$key]['id'] = $val['id']?:'';
            $data[$key]['vip_level'] = $val['vip_level']?:0;
            $data[$key]['name'] = $val['name']?:'';
            $data[$key]['power'] = $val['power']?:'';
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::FISHING_GUNS_KEY, $data)) {
            return $this->jsonTable('','', 0,'保存成功!');
        }
        return $this->jsonTable('','', 1,'保存失败！');

    }

    /**
     * 发送到服务器配置
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(){
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_GUNS_KEY);
        $params = json_encode([SysConfigModel::FISHING_GUNS_KEY => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }





}
