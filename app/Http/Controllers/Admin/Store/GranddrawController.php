<?php

namespace App\Http\Controllers\Admin\Store;
use App\Http\Controllers\Controller;
use App\Library\Tools\Covert;
use App\Models\SysConfigModel;
use App\Models\TmpAwardDataModel;
use App\Models\TmpAwardRecordModel;
use App\Models\TmpAwardStoreCoinsModel;
use App\Repositories\BaseRepository;
use App\Repositories\StoreRepository;
use App\Repositories\TmpAwardDataRepository;
use App\Traits\ActivityConfigTrait;
use App\Repositories\ActivityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GranddrawController extends Controller{
    use ActivityConfigTrait;
    /**
     *  大抽奖库存配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $listData = StoreRepository::granddraw();
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::AWARD_ONE);
        return view('admin.store.granddraw.index',['data' => $rest, 'listData' => $listData]);
    }

    /**
     *  大抽奖玩法配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function playlist(){
        $paramArr = $this->getActivityItemConfig(1,ActivityRepository::class)['card_rate'];
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::AWARD_TWO);
        return view('admin.store.granddraw.playlist',['data' => $rest,'paramArr' => $paramArr]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        foreach ($data as $key=>$val){
            $data[$key] = empty($data[$key]) ? 0 : $data[$key];
        }
        //如果不为空，会增加库存
        if ($data['add_money'] != 0) {
            $monty = intval($data['add_money'] * 100) ;
            $ret = StoreRepository::addGranddraw($monty);
            if ($ret['code'] != 0) {
                return $this->json([], 1,'库存添加失败！');
            }
        }
        unset($data['add_money']);
        if (SysConfigModel::saveSysVal(SysConfigModel::AWARD_ONE, $data)) {
            return $this->json([],0,'保存成功!');
        }
        return $this->json([], 1,'保存失败！');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function playsave(Request $request){
        $data = $request->get('data','');
        $card = $request->get('card','');

        $rate = $request->get('rate','');
        $award_coins = $request->get('award_coins','');
        foreach ($data as $key=>$val){
            $data[$key] = empty($data[$key]) ? 0 : $data[$key];
        }

        $card_rate = [];
        $array = [
            'A' => 1,'J' => 11, 'Q' => 12, 'K' => 13, '小王' => 14, '大王' => 15
        ];
        foreach ($card as $k => $c) {
            if (isset($array[$c])) {
                $c = $array[$c];
            }
            $card_rate[$k+1] = [
                'card' => $c,
                'rate' => $rate[$k],
                'award_coins' => $award_coins[$k]
            ];
        }
        $data['card_rate'] = $card_rate;

        if (SysConfigModel::saveSysVal(SysConfigModel::AWARD_TWO, $data)) {
            return $this->json([],0,'保存成功!');
        }
        return $this->json([], 1,'保存失败！');
    }

    /**
     * 抽水数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataList(){
        return view('admin.store.granddraw.list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request){
        $limit = $request->get('limit',10);
        $model = TmpAwardStoreCoinsModel::query();
        $data = $model->select('cur_index','end_time','fee_coins','store_coins','store_system_add','award_pool_coins','award_pool_system_add')
            ->orderBy('cur_index','desc')->paginate($limit)->toArray();
        $listData = StoreRepository::granddraw();
        $listArray = [];
        if (!empty($listData)) {
            $listArray = [ 0 => [  //实时抽水数据
                    'cur_index' => 'New-第'.$listData['cur_index'].'期'.date('Ymd',$listData['end_time']),
                    'fee_coins' => $listData['fee_coins'],
                    'fee_coins' => $listData['fee_coins'],
                    'store_coins' => $listData['store_coins'],
                    'store_system_add' => $listData['store_system_add'],
                    'award_pool_coins' => $listData['award_pool_coins'],
                    'award_pool_system_add' => $listData['award_pool_system_add'],
                    'fee_store' => $listData['fee_coins'] + $listData['store_coins'] - 2000 - $listData['store_system_add'] - $listData['award_pool_system_add']
                ]
            ];
        }

        if (!empty($data['data'])) {
            foreach ($data['data'] as &$v) {
                $v['cur_index'] = '第'.$v['cur_index'].'期'.date('Ymd',$v['end_time']);
                //（抽水值-0）+（库存值-2000）-库存系统资助值-奖金系统资助
                $v['fee_store'] = toRmb($v['fee_coins'] + $v['store_coins'] - 2000 - $v['store_system_add'] - $v['award_pool_system_add']);
                $v['fee_coins'] = toRmb($v['fee_coins']);
                $v['store_coins'] = toRmb($v['store_coins']);
                $v['store_system_add'] = toRmb($v['store_system_add']);
                $v['award_pool_coins'] = toRmb($v['award_pool_coins']);
                $v['award_pool_system_add'] = toRmb($v['award_pool_system_add']);
            }
        }
        $new_array = array_merge($listArray,$data['data']);
        return $this->jsonTable($new_array,$data['total']);
    }

    /**
     * 大抽奖数据统计
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataCountList(){
        return view('admin.store.granddraw.count_list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataCountListGet(Request $request){
        $award_main = TmpAwardDataRepository::award_main();
        $limit = $request->get('limit', 10);
        $res = TmpAwardDataModel::query()
            ->orderBy('date', 'desc')
            ->paginate($limit)
            ->toArray();
        $new_array = array_merge($award_main,$res['data']);
        return $this->jsonTable($new_array,$res['total'],0,'正在请求中...');
    }

    /**
     * 大抽奖中奖名单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function winning(){
        //获取中奖期数下拉列表
        $data = TmpAwardRecordModel::query()
            ->orderBy('end_time','desc')
            ->groupBy('cur_index')
            ->get()->toArray();
        $select = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $time_str = date('Ymd',$v['end_time']);
                $select[$v['cur_index']] = '第'.$v['cur_index'].'期('.$time_str.')';
            }
        }
        $cur_index_max = TmpAwardRecordModel::query()->select(DB::Raw('max(cur_index) as cur_index'))->get()->toArray();
        $cur_index = !empty($cur_index_max) ? $cur_index_max[0]['cur_index'] : 0 ;
        return view('admin.store.granddraw.winning_list',['select' => $select, 'cur_index' => $cur_index]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function winningData(Request $request){
        $grade = $request->get('grade','');
        $model = TmpAwardRecordModel::query();
        if (!empty($grade)) {
            $model->where(['cur_index' => $grade]);
        } else {
            //默认显示最近一期的中奖名单
            $cur_index_max = TmpAwardRecordModel::query()->select(DB::Raw('max(cur_index) as cur_index'))->get()->toArray();
            $cur_index = !empty($cur_index_max) ? $cur_index_max[0]['cur_index'] : 0 ;
            $model->where(['cur_index' => $cur_index]);
        }
        $res = $model->orderBy('cur_index', 'desc')->get()->toArray();
        $data = [];
        if (!empty($res)) {
            $data_str = $res[0]['player_award_list'];
            $data = json_decode($data_str,true);
            if (is_array($data) && !empty($data)) {
                foreach ($data as &$v) {
                    $v['award_coins'] = toRmb($v['award_coins']);
                }
            }
        }
        return $this->jsonTable($data,0,0,'正在请求中...');
    }


    /**
     * 发送到服务器配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(){
        $data = SysConfigModel::getManySysKeyExists([SysConfigModel::AWARD_ONE,SysConfigModel::AWARD_TWO]);
        if (empty($data[0]['sys_val']) || empty($data[1]['sys_val'])){
            return $this->json('', 1, '大抽奖抽水配置和大抽奖玩法配置都不能为空，请核实');
        }
        $listArray = array_merge($data[0]['sys_val'],$data[1]['sys_val']);

        $listArray['open'] = empty($listArray['open']) ? false : true ;
        $listArray['store_warn'] = empty($listArray['store_warn']) ? 0 : toMinute($listArray['store_warn']); //元转分
        $listArray['base_store_init'] = empty($listArray['base_store_init']) ? 0 : toMinute($listArray['base_store_init']); //元转分
        $listArray['add_coins_min'] = empty($listArray['add_coins_min']) ? 0 : toMinute($listArray['add_coins_min']); //元转分
        $listArray['add_coins_max'] = empty($listArray['add_coins_max']) ? 0 : toMinute($listArray['add_coins_max']); //元转分
        $listArray['charge_coins'] = empty($listArray['charge_coins']) ? 0 : toMinute($listArray['charge_coins']); //元转分
        $listArray['award_cost'] = empty($listArray['award_cost']) ? 0 : toMinute($listArray['award_cost']); //元转分

        foreach ($listArray['card_rate'] as &$v){
            $v['award_coins'] = toMinute($v['award_coins']);//元转分
        }

        $params = json_encode([SysConfigModel::AWARD => Covert::arrayToLuaStr($listArray)], JSON_UNESCAPED_UNICODE);
        $flag = BaseRepository::curl(config('server.upload_config_url'), $params);
        if ($flag == BaseRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}
