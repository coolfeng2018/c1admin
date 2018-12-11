<?php

namespace App\Http\Controllers\Admin\Store;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Models\TmpStoreResultModel;
use App\Repositories\BaseRepository;
use App\Repositories\StoreRepository;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;

class FishStoreController extends Controller{

    private static $config_filename = 'fishing_store.lua';

    private static $list = [
        '600'  => '扑鱼初级场',
        '601'  => '扑鱼中级场',
        '602'  => '扑鱼高级场'
    ];


    /**
     * p扑鱼库存配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$list;

        $list['key'] = json_encode(array_keys($list['data']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_STORE_KEY);
        $data = array(
            '600'  => $rest['600'] ?? [],
            '601'  => $rest['601'] ?? [],
            '602'  => $rest['602'] ?? [],
        );

        $url = config('server.server_api').'/gm';
        $temp = array();
        foreach ($list['data'] as $key=>$val){
            $params = array('cmd'=> 'getfishstore', 'table_type' =>$key );
            $rest = BaseRepository::apiCurl($url,$params,'POST','www');
            if ($rest['code'] == 0){
                $temp[$key]['adjust']  = toRmb($rest['fish_store']['pool_adjust']['curr']);
                $temp[$key]['control'] = toRmb($rest['fish_store']['pool_control']['curr']);
                $temp[$key]['addup']   = toRmb($rest['fish_store']['pool_addup']['curr']);
                $temp[$key]['sysback'] = toRmb($rest['fish_store']['pool_sysback']['curr']);
            }
        }
        foreach ($data as $key => $val){
            $data[$key]['adjust']  = $temp[$key]['adjust']  ?? 0;
            $data[$key]['control'] = $temp[$key]['control'] ?? 0;
            $data[$key]['addup']   = $temp[$key]['addup']   ?? 0;
            $data[$key]['sysback'] = $temp[$key]['sysback'] ?? 0;
        }

        return view('admin.store.fishstore.index',['data' => $data,'list' => $list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        $gameList = $request->get('list','');

        foreach ($data as $key=>$val){

            $data[$key]['sysback_fee_rate'] = is_numeric($val['sysback_fee_rate'])  ? $val['sysback_fee_rate']  :'';
            $data[$key]['control_fee_rate'] = is_numeric($val['control_fee_rate'])  ? $val['control_fee_rate']  :'';
            $data[$key]['control_base_warn']= is_numeric($val['control_base_warn']) ? $val['control_base_warn'] :'';
            $data[$key]['control_threshold']= is_numeric($val['control_threshold']) ? $val['control_threshold']:'';
            $data[$key]['control_factor']   = is_numeric($val['control_factor'])    ? $val['control_factor']   :'';
            $data[$key]['adjust_fee_rate']  = is_numeric($val['adjust_fee_rate'])   ? $val['adjust_fee_rate']   :'';
            $data[$key]['adjust_base_warn'] = is_numeric($val['adjust_base_warn'])  ? $val['adjust_base_warn']  :'';
            $data[$key]['adjust_trigger_rate']= is_numeric($val['adjust_trigger_rate'])? $val['adjust_trigger_rate']:'';
            $data[$key]['adjust_add_rate']    = is_numeric($val['adjust_add_rate'])    ? $val['adjust_add_rate']    :'';
            $data[$key]['addup_fee_rate']     = is_numeric($val['addup_fee_rate'])     ? $val['addup_fee_rate']     :'';
            $data[$key]['addup_base_goal']    = is_numeric($val['addup_base_goal'])    ? $val['addup_base_goal']    :'';
            $data[$key]['addup_base_warn']    = is_numeric($val['addup_base_warn'])    ? $val['addup_base_warn']    :'';
        }
        if (empty($data)){
            return $this->jsonTable('','', 1,'数据不能为空！');
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::FISHING_STORE_KEY, $data)) {
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
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::FISHING_STORE_KEY);
        $list = [];
        foreach ($data as $key=>$val){
            $list[$key]['pool_sysback']['fee_rate']   = $val['sysback_fee_rate'];
            $list[$key]['pool_control']['fee_rate']   = $val['control_fee_rate'];
            $list[$key]['pool_control']['base_warn']  = toMinute($val['control_base_warn']);
            $list[$key]['pool_control']['threshold']   = toMinute($val['control_threshold']);
            $list[$key]['pool_control']['factor']     = toMinute($val['control_factor']);

            $list[$key]['pool_adjust']['fee_rate']    = $val['adjust_fee_rate'];
            $list[$key]['pool_adjust']['base_warn']   = toMinute($val['adjust_base_warn']);
            $list[$key]['pool_adjust']['trigger_rate']= $val['adjust_trigger_rate'];
            $list[$key]['pool_adjust']['add_rate']    = $val['adjust_add_rate'];
            $list[$key]['pool_addup']['fee_rate']     = $val['addup_fee_rate'];
            $list[$key]['pool_addup']['base_goal']    = toMinute($val['addup_base_goal']);
            $list[$key]['pool_addup']['base_warn']    = toMinute($val['addup_base_warn']);
        }
        $params = json_encode([self::$config_filename => Covert::arrayToLuaStr($list)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }




    /**
     * 抽水数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataList(){
        $list = array(
            'fishing_junior'=>'捕鱼初级场 ',
            'fishing_normal'=>' 捕鱼普通场 ',
            'fishing_three' =>'捕鱼精英场 '
        );
        return view('admin.store.fishstore.list',['list' => $list]);
    }

    public function data(Request $request){
        $robot_type = $request->get('grade','fishing_junior');
        $limit = $request->get('limit',10);
        $model = TmpStoreResultModel::query();
        $data = $model->where('robot_type',$robot_type)->orderBy('modified_time','desc')->paginate($limit+1)->toArray();
        $data = StoreRepository::assemble($data,$limit);
        return $this->jsonTable($data['data'],$data['total']);
    }


}
