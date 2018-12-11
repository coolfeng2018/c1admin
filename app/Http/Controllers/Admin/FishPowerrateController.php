<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class FishPowerrateController extends Controller{

    private static $lsit = [
        'powerrate'        => '火力对应的概率系数',
    ];


    /**
     * 扑鱼修正配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$lsit;
        $list['key'] = json_encode(array_keys($list['data']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_POWERRATE_KEY);
        $data = array(
            'powerrate'        => $rest['powerrate'] ??[],
        );
        return view('admin.fishpowerrate.index',['data' => $data,'list' => $list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        $lsit = self::$lsit;
        foreach ($lsit as $key=>$val){
            $listData[$key] = $data ?? [];
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::FISHING_POWERRATE_KEY, $listData)) {
            return $this->json('', 0,'保存成功!');
        }
        return $this->json('', 1,'保存失败！');

    }


    /**
     * 发送到服务器配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(){
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_POWERRATE_KEY);
        $list = [];
        foreach ($data['powerrate'] as $key=>$val){
            $list[$val['key']] = $val['val'];
        }
        $params = json_encode([SysConfigModel::FISHING_POWERRATE_KEY => Covert::arrayToLuaStr($list)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        }
        return $this->json('', 1, '发送配置失败');


    }

}
