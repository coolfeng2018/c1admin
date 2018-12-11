<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class FishPlayerController extends Controller{

    private static $config_filename = 'fishing_catch_rate.lua';

    /**
     * 扑鱼玩家命中率配置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = array(
            'lose' => '亏损范围',
            'win'  => '盈利范围',
        );
        $list['game'] = array(
            '600'  => '扑鱼初级场',
            '601' => '扑鱼中级场',
            '602' => '扑鱼高级场',
        );
        $list['key']   = json_encode(array_keys($list['data']));
        $list['field'] = json_encode(array_keys($list['game']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::FISH_PLAYER_RATE_CONFIG_KEY);
        $data = [];
        foreach ($list['game'] as $key=>$val){
            $data[$key] = $rest[$key] ?? [];
            foreach ($list['data'] as $k=>$v){
                $data[$key][$k] = isset($rest[$key][$k]) ? $rest[$key][$k] : [];
            }
        }
        return view('admin.fishplayer.index',['data' => $data,'list' => $list]);
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
                    $temp[$key][$k][$kk]['min'] = $vv['min'];
                    $temp[$key][$k][$kk]['max'] = $vv['max'];
                    $temp[$key][$k][$kk]['str'] = $vv['str'];
                }
            }
        }

        if (SysConfigModel::saveSysVal(SysConfigModel::FISH_PLAYER_RATE_CONFIG_KEY, $temp)) {
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
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::FISH_PLAYER_RATE_CONFIG_KEY);

        $list = [];
        foreach ($data as $key => $val){
            foreach ($val as $k=>$v){
                foreach ($v as $i=>$v){
                    $list[$key][$k][$i][0] =$v['min'];
                    $list[$key][$k][$i][1] =$v['max'];
                    $list[$key][$k][$i][2] =$v['str'];
                }
            }
        }

        $params = json_encode([self::$config_filename => Covert::arrayToLuaStr($list)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }

    }

}
