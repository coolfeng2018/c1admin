<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class FishCorrectionController extends Controller{

    private static $lsit = [
        'adjust_rate'        => '调控放水',
        'cannot_catch_rate'  => '打不死鱼',
    ];


    /**
     * 扑鱼修正配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$lsit;
        $list['game'] = array(
            '600'  => '扑鱼初级场',
            '601' => '扑鱼中级场',
            '602' => '扑鱼高级场',
        );
        $list['key']   = json_encode(array_keys($list['data']));
        $list['field'] = json_encode(array_keys($list['game']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_CORRECTION_KEY);
        $data = [];
        foreach ($list['game'] as $key=>$val){
            $data[$key] = $rest[$key] ?? [];
            foreach ($list['data'] as $k=>$v){
                $data[$key][$k] = isset($rest[$key][$k]) ? $rest[$key][$k] : [];
            }
        }
        return view('admin.fishcorrection.index',['data' => $data,'list' => $list]);



    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        $list = $request->get('list','');
        $data  = json_decode($data,1);
        $list  = json_decode($list);
        if (empty($data) || empty($list)){
            return $this->jsonTable('','', 1,'数据不能为空！');
        }

        $temp = [];
        foreach ($data as  $key=>$val){
            foreach ($val as $k=>$v){
                foreach ($v as $kk=>$vv){
                    $temp[$key][$k][$kk]['fish_score_min'] = $vv['fish_score_min'];
                    $temp[$key][$k][$kk]['fish_score_max'] = $vv['fish_score_max'];
                    $temp[$key][$k][$kk]['coefficient'] = $vv['coefficient'];
                }
            }
        }

        if (SysConfigModel::saveSysVal(SysConfigModel::FISHING_CORRECTION_KEY, $temp)) {
            return $this->jsonTable('','', 0,'保存成功!');
        }
        return $this->jsonTable('','', 1,'保存失败！');

    }


    /**
     * 发送到服务器配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(){
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_CORRECTION_KEY);
        $list = [];
        foreach ($data as $key => $val){
            foreach ($val as $k=>$v){
                foreach ($v as $i=>$v){
                    $list[$key][$k][$i]['fish_score'][0] =$v['fish_score_min'];
                    $list[$key][$k][$i]['fish_score'][1] =$v['fish_score_max'];
                    $list[$key][$k][$i]['coefficient']   =$v['coefficient'];
                }
            }
        }
        $params = json_encode([SysConfigModel::FISHING_CORRECTION_KEY => Covert::arrayToLuaStr($list)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        }
        return $this->json('', 1, '发送配置失败');


    }

}
