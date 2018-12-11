<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Repositories\ActivityRepository;
use App\Traits\ActivityConfigTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 拉新活动-排行榜 信息
 * Class PullNewActivityController
 * @package App\Http\Controllers\Admin
 */
class ActivityPullNewController extends Controller
{
    use ActivityConfigTrait;

    const ACT_TYPE = 1 ; //拉新活动类型
    /**
     * 充值列表首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.activity.pullnew.index');
    }

    /**
     * 充值列表获取
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = ActivityRepository::getActivityRank(self::ACT_TYPE);
        return $this->jsonTable($data,0,0,'正在请求中...');
    }

    /**
     * 添加积分
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addScore(Request $request){
        $uid = $request->get('uid',0);
        $score = $request->get('score',0);
        $ret = ActivityRepository::addActivityScore(self::ACT_TYPE,$uid,$score);
        if($ret){
            return $this->json($ret,0,'添加成功');
        }
        return $this->json($ret,201);
    }

    /**
     * 添加机器人
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addRobot(Request $request){
        $name = $request->get('name','');
        $score = $request->get('score',0);
        $ret = ActivityRepository::addActivityRobot(self::ACT_TYPE,$name,intval($score));
        if($ret){
            return $this->json($ret,0,'添加成功');
        }
        return $this->json($ret,201);
    }

    /**
     * 添加库存
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addstore(Request $request){

        $store = $request->get('store',0); //库存
        if($store <= 0){
            return $this->json('',201,'库存值不能小于等于 0 ');
        }
        $ret = $this->setActStoreReal(self::ACT_TYPE,$store,ActivityRepository::class);
        if($ret){
            return $this->json($ret,0,'添加成功');
        }
        return $this->json($ret,201);
    }
}
