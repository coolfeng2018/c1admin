<?php

namespace App\Http\Controllers\Admin\GameConfig;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Repositories\BaseRepository;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class BrnnBankerController extends Controller{

    private static $list = [
        'brnn_normal'  => '百人牛牛3倍场系统庄家配置',
        'brnn_ten_normal'  => '百人牛牛10倍场系统庄家配置',
    ];


    /**
     * 百人牛牛系统庄家配置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$list;
        $list['key'] = json_encode(array_keys($list['data']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::BRNN_BANKER_KEY);

        $data = array(
            'brnn_normal'  => $rest['brnn_normal'] ?? [],
            'brnn_ten_normal'  => $rest['brnn_ten_normal'] ?? [],
        );
        return view('admin.gameconfig.brnnbanker.index',['data' => $data,'list' => $list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        if (empty($data)){
            return $this->jsonTable('','', 1,'数据不能为空！');
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::BRNN_BANKER_KEY, $data)) {
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
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::BRNN_BANKER_KEY);
        foreach ($data as $key=>$val){
            foreach ($val as $k=>$v){
                foreach ($v as $ki=>$vl){
                    $data[$key][$k][$ki] = $vl ?? '';
                }
            }
        }
        foreach ($data as $key=>$val){
            foreach ($val['BANKER_STORE'] as $k=>$v){
                $data[$key]['BANKER_STORE'][$k] = (explode(',',trim(str_replace('，',',',$v),',')));
            }
            $data[$key]['EXTRA_FEE_PERCENT'] = $val['EXTRA_FEE_PERCENT']['EXTRA_FEE_PERCENT'] ?? '';
        }
        $params = json_encode([SysConfigModel::BRNN_BANKER_KEY => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }



}
