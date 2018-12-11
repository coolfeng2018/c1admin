<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SysConfigModel;
use App\Repositories\CacheKey;
use App\Repositories\SysConfigRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * 用户引导 - frans
 * Class LeadController
 * @package App\Http\Controllers\Admin
 */
class LeadController extends Controller
{

    /**
     * 取得服务端游戏列表
     * @return array|mixed
     */
    private function getGameList()
    {

//        $key = config('cacheKey.SERVER_GAME_LIST');
//
//        if (Cache::has($key)) {
//            return Cache::get($key);
//        } else {
//            $data = (new Client())->post(config('server.game_list'))->getBody()->getContents();
//            $data = json_decode($data, true);
//            dump($data);
//            if ($data) {
//                Cache::put($key, $data['game_list'], 86400);
//                return $data['game_list'];
//            } else {
//                return [];
//            }
//        }

        $game_list = DB::connection(config('constants.MYSQL_ONE_BY_ONE'))
            ->table('games')
            ->select(DB::raw('game_type as value, game_name as name'))
            ->get()->toArray();

        $game_list = array_map('get_object_vars', $game_list);
        return $game_list;
    }

    /**
     * 用户引导配置
     */
    public function index()
    {
        $config = SysConfigModel::getSysKeyExists(SysConfigModel::USER_GUIDE_KEY);
        $game_list = $this->getGameList();

        return view('admin.lead.index', ['config' => $config, 'game_list' => $game_list]);
    }

    /**
     * 用户触发配置
     */
    public function trigger()
    {
        $config = SysConfigModel::getSysKeyExists(SysConfigModel::USER_TRIGGER_KEY);
        return view('admin.lead.trigger', ['config' => $config]);
    }

    /**
     * GM配置
     */
    public function personal()
    {
        $config = SysConfigModel::getSysKeyExists(SysConfigModel::PERSONAL_CONTROL_KEY);
        return view('admin.lead.personal', ['config' => $config]);
    }


    //======================保存配置=================================================

    /**
     * 保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUserGuideConfig(Request $request)
    {
        $data = $request->all();
        if (SysConfigModel::saveSysVal(SysConfigModel::USER_GUIDE_KEY, $data)) {
            return redirect(route('admin.lead.index'))->with(['status' => '更新完成']);
        }
        return redirect(route('admin.lead.index'))->with(['status' => '系统错误']);
    }

    /**
     * 保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUserTriggerConfig(Request $request)
    {
        $data = $request->all();
        if (SysConfigModel::saveSysVal(SysConfigModel::USER_TRIGGER_KEY, $data)) {
            return redirect(route('admin.lead.trigger'))->with(['status' => '更新完成']);
        }
        return redirect(route('admin.lead.trigger'))->with(['status' => '系统错误']);
    }

    /**
     * 保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function savePersonalConfig(Request $request)
    {
        $data = $request->all();
        if (SysConfigModel::saveSysVal(SysConfigModel::PERSONAL_CONTROL_KEY, $data)) {
            return redirect(route('admin.lead.personal'))->with(['status' => '更新完成']);
        }
        return redirect(route('admin.lead.personal'))->with(['status' => '系统错误']);
    }

    //===================发送配置=================================
    public function sendUserGuideConfig()
    {
        $flag = SysConfigRepository::updateUserGuideConfig();

        if ($flag == SysConfigRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

    public function sendUserTriggerConfig()
    {
        $flag = SysConfigRepository::updateUserTriggerConfig();

        if ($flag == SysConfigRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

    public function sendPersonalConfig()
    {
        $flag = SysConfigRepository::updatePersonalControlConfig();

        if ($flag == SysConfigRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}