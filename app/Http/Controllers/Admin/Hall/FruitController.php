<?php

namespace App\Http\Controllers\Admin\Hall;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class FruitController extends Controller{

    private static $lsit = [
        'bet_caijin'   => '下注金额',
    ];


    /**
     * 水果机配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$lsit;
        $list['key']  = json_encode(array_keys($list['data']));
        $list['list'] = config('game.fruit_list');
        $list['fruitStr'] = json_encode(config('game.fruit_list'));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::FRUIT_TIGER_RATE_KEY);
        $data = array(
            'bet_caijin'   => $rest['bet_caijin']  ??[],
        );
        return view('admin.hall.fruit.index',['data' => $data,'list' => $list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        $gameLsit = self::$lsit;
        foreach ($gameLsit as $key=>$val){
            $listData[$key] = $list[$key] ?? [];
        }
        $listData['bet_caijin'] = $data['bet_caijin'] ?? [];
        if (SysConfigModel::saveSysVal(SysConfigModel::FRUIT_TIGER_RATE_KEY, $listData)) {
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
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::FRUIT_TIGER_RATE_KEY);
        if (!$data){
            return $this->json('', 1, '配置中没有数据');
        }
        $list = [];

        $list['bet_range'] = explode(',',str_replace('，',',', $data['bet_caijin']['bet_range']));
        foreach ($list['bet_range'] as $key=>$val){
            $list['bet_range'][$key] = toMinute($val);
        }
        $caijin_rate = [];
        foreach ($data['bet_caijin']['caijin_rate'] as $key=>$val){
            list($a, $b) = explode('=',$val);
            $caijin_rate += [$a=>$b];
        }
        $list['caijin_rate'] = $caijin_rate;
        $params = json_encode([SysConfigModel::FRUIT_TIGER_RATE_KEY => Covert::arrayToLuaStr($list)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        }
        return $this->json('', 1, '发送配置失败');


    }

}
