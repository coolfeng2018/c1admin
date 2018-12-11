<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class HundredController extends Controller{

    private static $config_filename = 'bet_list.lua';


    /**
     * 百人场配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = array(
            'hhdz'     => '红黑大战',
            'brnn'     => '百人牛牛-3倍场',
            'brnn_ten' => '百人牛牛-10倍场',
            'lfdj'     => '龙虎斗'
        );

        $list['key'] = json_encode(array_keys($list['data']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::HUNDRED_CONFIG_KEY);
        $data = array(
            'hhdz'     => $rest['data']['hhdz']     ?? [],
            'brnn'     => $rest['data']['brnn']     ?? [],
            'brnn_ten' => $rest['data']['brnn_ten'] ?? [],
            'lfdj'     => $rest['data']['lfdj']     ?? [],
        );
        $minBet= $rest['minBet'] ?? [];
        return view('admin.hundred.index',['data' => $data,'list' => $list,'minBet'=>$minBet]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $param['data'] = $request->get('data','');
        $param['list'] = $request->get('list','');
        $minBet = $request->get('minBet','');
        $data  = json_decode($param['data']);
        $list  = json_decode($param['list']);

        if (empty($data) || empty($list)){
            return $this->jsonTable('','', 1,'数据不能为空！');
        }
        foreach ($data as  $key=>$val){
            foreach ($val as $k => $v){
                $temp['min'] = $v[0];
                $temp['max'] = $v[1];
                $temp['str'] = $v[2];
                $data[$key][$k] = $temp;
            }
        }
        $listData['minBet'] = $minBet;
        foreach ($list as $key=>$val){
            $listData['data'][$val] = $data[$key];
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::HUNDRED_CONFIG_KEY, $listData)) {
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
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::HUNDRED_CONFIG_KEY);
        $list = [];
        foreach ($data['data'] as $key => $val){
            $type= $key."_bet_list";
            foreach ($val as $k=>$v){
                $list[$type][$k]["coins_range"] = ((int)$v['min']*100) .'-'.((int)$v['max']?(int)$v['max']*100:'');
                $temp = explode(',',trim($v['str'],','));
                foreach ($temp as $ky=>$value){
                    $temp[$ky] = (int)$value *100;
                }
                $list[$type][$k]["bet_list"]    =  $temp;
            }
        }

        $list['hhdz_min_bet']      = $data['minBet']['hhdz_min_bet']*100;
        $list['brnn_min_bet']      = $data['minBet']['brnn_min_bet']*100;
        $list['brnn_ten_min_bet']  = $data['minBet']['brnn_ten_min_bet']*100;
        $list['lfdj_min_bet']      = $data['minBet']['lfdj_min_bet']*100;
        $params = json_encode([self::$config_filename => Covert::arrayToLuaStr($list)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }

    }

}
