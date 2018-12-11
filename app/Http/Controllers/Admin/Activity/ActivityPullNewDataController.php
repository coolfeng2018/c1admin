<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Repositories\ActivityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 拉新活动-数据统计信息
 * Class PullNewActivityController
 * @package App\Http\Controllers\Admin
 */
class ActivityPullNewDataController extends Controller
{

    const ACT_TYPE = 1 ; //拉新活动类型
    /**
     * 充值列表首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.activity.pullnew.data');
    }

    /**
     * 充值列表获取
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $sdate = $request->get('sdate',date("Y-m-d",strtotime("-1 day")));
        $edate = $request->get('edate',date("Y-m-d"));
        $data = ActivityRepository::getPullNewData($sdate,$edate);
        return $this->jsonTable($data,0,0,'正在请求中...');
    }

    /**
     * 获取奖励详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request){
        $date = $request->get('date','');
        $data = '';
        if($date){
            $detail = ActivityRepository::getPullNewAwardData($date);
            $data = response(view('admin.activity.pullnew.details',compact('detail')))->getContent();
        }
        return $data;
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
}
