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
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class FruitsStoreController extends Controller{

    private static $list = [
        'fruit_nomal' => '水果机',
    ];

    /**
     *  水果机库存配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$list;
        $list['key'] = json_encode(array_keys($list['data']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::STORE_FRUIT_KEY);
        $data = array(
          "store_system_back"    => $rest['store_system_back']    ?? [],
          "store_base_sys"       => $rest['store_base_sys']       ?? [],
          "store_adjust"         => $rest['store_adjust']         ?? [],
          "store_real_jackpot"   => $rest['store_real_jackpot']   ?? [],
          "store_unreal_jackpot" => $rest['store_unreal_jackpot'] ?? [],
          "free_tiems"           => $rest['free_tiems'] ?? []
        );
        $data['fruit_nomal'] = StoreRepository::fruitList($data);
        //dd($data);
        return view('admin.store.fruitsstore.index',['data' => $data,'list' => $list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        $list = [];
        $count = 0;
        foreach ($data as $key=>$val){
            foreach ($val as $k=>$v){
                $list[$key][$k] = $v ?? 0;
            }
            $count += $val['contribute_rate'] ?? 0;
        }

        if ($count != 10000){
            return $this->json([],1,'贡献比例总和必须等于 10000');
        }
        if (empty($list)){
            return $this->json([],1,'数据不能为空！');
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::STORE_FRUIT_KEY, $list)) {
            return $this->json([],0,'保存成功!');
        }
        return $this->json([], 1,'保存失败！');
    }

    /**
     * 抽水数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataList(){
        return view('admin.store.fruitsstore.list',['list' => self::$list]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request){
        $robot_type = $request->get('grade','fruit_nomal');
        $limit = $request->get('limit',10);
        $model = TmpStoreResultModel::query();
        $data = $model->where('robot_type',$robot_type)->orderBy('modified_time','desc')->paginate($limit+1)->toArray();
        $data = StoreRepository::assemble($data,$limit);
        return $this->jsonTable($data['data'],$data['total']);
    }


    /**
     * 发送到服务器配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(){
        $data = SysConfigModel::getSysKeyExists(SysConfigModel::STORE_FRUIT_KEY);
        if (empty($data)){
            return $this->json('', 1, '发送失败,数据不能为空');
        }
        $list = [];
        foreach ($data as $key=>$val){
            if ($key=='store_unreal_jackpot'){
                $list['coins_hight'] = toMinute($val['coins_hight']);
                $list['coins_low']   = toMinute($val['coins_low']);
                $list['update_rate'] = [$val['update_rate_min'],$val['update_rate_max']];
                $list['add_coins']   = [toMinute($val['add_coins_min']),toMinute($val['add_coins_max'])];
                $list['grand_cycle'] = [$val['grand_cycle_min'],$val['grand_cycle_max']];
                $list['grand_coins'] = [toMinute($val['grand_coins_min']),toMinute($val['grand_coins_max'])];
                $data[$key] = $list;
            }
        }
        $data['store_adjust']['target_turnover']        = toMinute($data['store_adjust']['target_turnover']);
        $data['store_real_jackpot']['target_turnover']  = toMinute($data['store_real_jackpot']['target_turnover']);
        $data['store_base_sys']['base_warn']            = toMinute($data['store_base_sys']['base_warn']);
        $data['store_adjust']['base_warn']              = toMinute($data['store_adjust']['base_warn']);
        $data['store_real_jackpot']['base_warn']        = toMinute($data['store_real_jackpot']['base_warn']);

        $params = json_encode([SysConfigModel::STORE_FRUIT_KEY => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}
