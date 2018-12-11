<?php

namespace App\Http\Controllers\Admin\Hall;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class WeekRewardController extends Controller{

    private static $lsit = [
        'weekreward'     => '周福利-返利配置',
    ];


    /**
     * 周福利配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$lsit;
        $list['key'] = json_encode(array_keys($list['data']));
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::WEEK_REWARD_KEY);

        $data = $data ?? [];

        return view('admin.hall.weekreward.index',['data' => $data,'list' => $list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        if (SysConfigModel::saveSysVal(SysConfigModel::WEEK_REWARD_KEY, $data)) {
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
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::WEEK_REWARD_KEY);
        foreach ($data as $key=>$val){
            $data[$key]['coins_hight'] = toMinute($val['coins_hight']);
            $data[$key]['coins_low']   = toMinute($val['coins_low']);
        }

        $params = json_encode([SysConfigModel::WEEK_REWARD_KEY => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        }
        return $this->json('', 1, '发送配置失败');

    }

}
