<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\DataMammonModel;
use App\Models\SysConfigModel;
use App\Models\TmpStoreResultModel;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Library\Tools\Covert;
use Illuminate\Support\Facades\DB;

class MammonStoreController extends Controller
{

    private static $list = [
        'caishenjiadao_normal' => '财神驾到 ',
    ];

    /**
     *  财神库存配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $list['data'] = self::$list;
        $list['key'] = json_encode(array_keys($list['data']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::STORE_MAMMON_KEY);
        $result = StoreRepository::mammon();
        $data = '';
        if($result['code'] == '0'){
            $data = StoreRepository::mammon()['caishenstore'];
        };
        return view('admin.store.mammonstore.index', compact('rest','data'));
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $data = $request->get('data', '');
        $data['base_goal'] = $data['base_goal']*100;
        $data['base_warn'] = $data['base_warn']*100;

        if (SysConfigModel::saveSysVal(SysConfigModel::STORE_MAMMON_KEY, $data)) {
            return $this->json([], 0, '保存成功!');
        }
        return $this->json([], 1, '保存失败！');
    }


    /**
     * 抽水数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataList()
    {
        return view('admin.store.mammonstore.list', ['list' => self::$list]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {

        $limit = $request->get('limit', 10);

        $model = TmpStoreResultModel::query();
        $data = $model->where('robot_type', 'caishen_normal')->orderBy('modified_time', 'desc')->paginate($limit)->toArray();

        $data = StoreRepository::assemble($data, $limit);
        return $this->jsonTable($data['data'], $data['total']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        $data = SysConfigModel::getManySysKeyExists([SysConfigModel::STORE_MAMMON_KEY])[0]['sys_val'];
        if (empty($data)) {
            return $this->json('', 1, '发送失败,数据不能为空');
        }

        $params = json_encode([SysConfigModel::STORE_MAMMON_KEY => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }


    public function playlist()
    {
        $list ='';
        if(!empty(SysConfigModel::getManySysKeyExists([SysConfigModel::HALL_MAMMON_KEY]))){
            $list = SysConfigModel::getManySysKeyExists([SysConfigModel::HALL_MAMMON_KEY])[0]['sys_val'];
        }

        $data = config('game.table_list');
        unset($data[0]);
        return view('admin.store.mammonstore.playlist', compact('data','list'));
    }


    /**
     *  保存游戏配置数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function playSave(Request $request)
    {

        $data = $request->all();
        foreach ($data['room_type_rate'] as $k => $v) {
            if (empty($v)) $data['room_type_rate'][$k] = '0';
        }
        !empty($data['tigger_coins']) or $data['tigger_coins'] = '0';
        !empty($data['countdown_time']) or $data['countdown_time'] = '0';
        !empty($data['interval']) or $data['interval'] = '0';
        $data['tigger_coins'] = $data['tigger_coins']*100;
        if (SysConfigModel::saveSysVal(SysConfigModel::HALL_MAMMON_KEY, $data)) {
            return $this->json([], 0, '保存成功!');
        }
        return $this->json([], 1, '保存失败！');
    }


    /**
     * 游戏配置发送
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function playSend()
    {
        $data = SysConfigModel::getManySysKeyExists([SysConfigModel::HALL_MAMMON_KEY])[0]['sys_val'];
        if (empty($data)) {
            return $this->json('', 1, '发送失败,数据不能为空');
        }
        $data['switch'] = boolval($data['switch']);
        $params = json_encode([SysConfigModel::HALL_MAMMON_KEY => Covert::arrayToLuaStr($data)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }


    public function stat(){
        $data = config('game.table_list');
        return view('admin.store.mammonstore.stat', ['list' => $data]);
    }



    public function statData(Request $request){
        $table_type = $request->get('table_type', '0');
        $limit = $request->get('limit', 10);

        if($table_type == 0){
            $model = DataMammonModel::query();
            $model->select(DB::raw('days,sum(`trigger`) as `trigger`,sum(`buy_num`) as `buy_num`,sum(`buy_usr`) as `buy_usr`,sum(`award_num`) as `award_num`,sum(`award_usr`) as `award_usr`'));
            $model->orderBy('days', 'desc');
            $model->groupBy('days');
            $data = $model->paginate($limit)->toArray();
        }else{
            $data = DataMammonModel::where('table_type', $table_type)->orderBy('days', 'desc')->paginate($limit)->toArray();
        }

        return $this->jsonTable($data['data'], $data['total']);
    }


}
