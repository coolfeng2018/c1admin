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
use App\Models\DataRankBoard;
use App\Models\SysConfigModel;
use App\Repositories\NoticeRepository;
use App\Repositories\RankRepository;
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
class RankController extends Controller
{
    /**
     * 排行榜实时首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 1);

        //{"cmd":"get_rank_list","rank_type":1}
        //rank_type表示排行榜类型，1 赚金币排行榜 2 提现排行榜 3 在线时长排行榜
        $result = RankRepository::getServerRankData(config('server.rank_list_url'), ['cmd' => 'get_rank_list', 'rank_type' => $type]);
        $result = is_array($result) && $result['code'] == 1 ? $result['data']['data'] : [];

        return view('admin.rank.index', [
            'type' => $type,
            'data' => $result
        ]);
    }

    /**
     * 历史数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history(Request $request)
    {

        $type = $request->get('type', 1);

        $model = DataRankBoard::query();

        //查询
        $model = $model->where('type', $type);

        if ($request->get('uid')) {
            $model = $model->where('uid', $request->get('uid'));
        }

        if ($request->get('date')) {
            $date = $request->get('date');
            $model = $model->where('created_at', '>=', strtotime($date))
                ->where('created_at', '<=', strtotime($date) + 86400);
        }

        //排序
        switch ($type) {
            case 1:
                $model->orderBy('today_income', 'desc');
                break;
            case 2:
                $model->orderBy('charge_money', 'desc');
                break;
            case 3:
                $model->orderBy('online_time', 'desc');
                break;
            default :
                $model->orderBy('id', 'desc');
                break;
        }

        $result = $model->paginate(15);

        return view('admin.rank.history', [
                'result' => $result,
                'type' => $type,
                'uid' => $request->get('uid', ''),
                'date' => $request->get('date', '')
            ]
        );
    }

    /**
     * 排行榜配置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function config(Request $request)
    {
        $rank_field = SysConfigModel::RANK_CONTROL_FIELD;

        $rank_count = SysConfigModel::query()->where(['sys_key' => SysConfigModel::RANK_CONTROL_KEY])->count();
        $rank_config = [];
        if ($rank_count > 0) {
            $rank_config = SysConfigModel::where(['sys_key' => SysConfigModel::RANK_CONTROL_KEY])->first()->toArray();
            $rank_config = $rank_config['sys_val'];
            foreach ($rank_field as $k => $v) {
                if (isset($rank_config[$v['name']])) {
                    $rank_field[$k]['value'] = $rank_config[$v['name']];
                }
            }
        }

        return view('admin.rank.config', ['rank_field' => $rank_field, 'rank_config' => $rank_config]);
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

        if (($data['refresh_time'] * 60) < $data['time']) {
            return redirect(route('admin.rank.config'))->with(['status' => ' 时间配置有误，必须满足"刷新时间 * 60 >= 在线时长"']);
        }

        if (SysConfigModel::saveSysVal(SysConfigModel::RANK_CONTROL_KEY, $data)) {
            return redirect(route('admin.rank.config'))->with(['status' => '更新完成']);
        }
        return redirect(route('admin.rank.config'))->with(['status' => '系统错误']);
    }

    /**
     * 发送配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {

        $flag = SysConfigRepository::uploadRankConfig();

        if ($flag == NoticeRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

    /**
     * 接收服务端数据 TODO：已经转移到API项目
     */
//    public function receiveServerData(Request $request)
//    {
//        Log::info(__METHOD__ . json_encode($request->json()->all()));
//
//        set_time_limit(0);
//        $result = RankRepository::setServerRankData($request->json()->all());
//        if (is_array($result) && $result['code'] == 1) {
//            return $this->json('', 0, $result['msg']);
//        } else {
//            return $this->json('', 1, $result['msg']);
//        }
//    }

}