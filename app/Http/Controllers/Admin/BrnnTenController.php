<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/18 18:40
 * +------------------------------
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SysConfigModel;
use App\Repositories\NoticeRepository;
use App\Repositories\SysConfigRepository;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * 排行榜
 * Class RankController
 * @package App\Http\Controllers\Admin
 */
class BrnnTenController extends Controller
{

    /**
     * 排行榜配置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function config(Request $request)
    {
        $brnn_field = SysConfigModel::ROBOT_BANKER_CONTROL_FIELD;

        $brnn_count = SysConfigModel::query()->where(['sys_key' => SysConfigModel::ROBOT_TEN_BANKER_CONTROL_KEY])->count();
        $brnn_config = [];
        if ($brnn_count > 0) {
            $brnn_config = SysConfigModel::where(['sys_key' => SysConfigModel::ROBOT_TEN_BANKER_CONTROL_KEY])->first()->toArray();
            $brnn_config = $brnn_config['sys_val'];
            foreach ($brnn_field as $k => $v) {
                if($v['name']=='banker_rate'){
                    $arr = [];
                    $arr['banker_rate_people_min'] = isset($brnn_config['banker_rate_people_min']) ? $brnn_config['banker_rate_people_min'] : [];
                    $arr['banker_rate_people_max'] = isset($brnn_config['banker_rate_people_max']) ? $brnn_config['banker_rate_people_max'] : [];
                    $arr['banker_rate_rate_min'] = isset($brnn_config['banker_rate_rate_min']) ? $brnn_config['banker_rate_rate_min'] : [];
                    $arr['banker_rate_people_num_min'] = isset($brnn_config['banker_rate_people_num_min']) ? $brnn_config['banker_rate_people_num_min'] : [];
                    $brnn_field[$k]['value'] = $arr;
                }
                if($v['name']=='banker_round'){
                    $arr = [];
                    $arr['banker_round_coin_min'] = isset($brnn_config['banker_round_coin_min']) ? $brnn_config['banker_round_coin_min'] : [];
                    $arr['banker_round_coin_max'] = isset($brnn_config['banker_round_coin_max']) ? $brnn_config['banker_round_coin_max'] : [];
                    $arr['banker_round_round_range_min'] = isset($brnn_config['banker_round_round_range_min']) ? $brnn_config['banker_round_round_range_min'] : [];
                    $arr['banker_round_round_range_max'] = isset($brnn_config['banker_round_round_range_max']) ? $brnn_config['banker_round_round_range_max'] : [];
                    $brnn_field[$k]['value'] = $arr;
                }
                if (isset($brnn_config[$v['name']])) {
                    $brnn_field[$k]['value'] = $brnn_config[$v['name']];
                }
            }
        }
        return view('admin.brnn.tenconfig', ['brnn_field' => $brnn_field, 'brnn_config' => $brnn_config]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (SysConfigModel::saveSysVal(SysConfigModel::ROBOT_TEN_BANKER_CONTROL_KEY, $data)) {
            return redirect(route('admin.brnnten'))->with(['status' => '更新完成']);
        }
        return redirect(route('admin.brnnten'))->with(['status' => '系统错误']);
    }

    /**
     * 发送配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {

        $flag = SysConfigRepository::uploadBrnnTenConfig();

        if ($flag == NoticeRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}