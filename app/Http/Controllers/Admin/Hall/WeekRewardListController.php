<?php

namespace App\Http\Controllers\Admin\Hall;

use App\Models\DataUnionOrderModel;
use App\Models\SysPayListsModel;
use App\Models\TmpDcusersModel;
use App\Models\TmpExchangeResultModel;
use App\Repositories\DataUnionOrderRepository;
use App\Repositories\SysActivityPayRepository;
use App\Repositories\SysPayListsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WeekRewardListController extends Controller
{
    /**
     * 周福利返水数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('admin.hall.weekreward.list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request){
        $uid = $request->get('uid','0');
        $limit = $request->get('limit',10);
        $model = TmpDcusersModel::query();
        if ($uid){
            $model->where('uid', $uid);
        }
        //$model->orderBy('modified_time','desc');
        $userData = $model->select('uid','nickname')->paginate($limit)->toArray();
        $list = [];
        $ids  = [];
        foreach ($userData['data'] as $key=>$val){
            $ids[$key] = $val['uid'];
            $list[$val['uid']] = array(
                'uid'                => $val['uid'],
                'nickname'           => $val['nickname'],
                'can_exchange_award' => 0,
                'last_award'         => 0,
                'total_award'        => 0,
                'day_count'          => '不可兑换'
            );
        }
        $data = self::getMongoDb('yange_data.base',['uid'=>['$in' =>$ids]]);
        if(!empty($data)){
            foreach ($data as $key=>$val) {
                if(isset($list[$val->uid])){
                    $rs = json_decode(json_encode($val),true);
                    $weekaward = isset($rs['week_award']) ? $rs['week_award'] : array() ;
                    $list[$val->uid]['uid'] = $val->uid ;
                    $list[$val->uid]['can_exchange_award'] = isset($weekaward['can_exchange_award']) ? round($weekaward['can_exchange_award']/100,3) : 0 ;
                    $list[$val->uid]['last_award']         = isset($weekaward['last_award']) ? round($weekaward['last_award']/100,3) : 0 ;
                    $list[$val->uid]['total_award']        = isset($weekaward['total_award']) ? round($weekaward['total_award']/100,3) : 0 ;
                    $list[$val->uid]['day_count']          = (isset($weekaward['day_count']) && $weekaward['day_count'] >7) ? "可兑换" : "不可兑换" ;
                }
            }
        }
        return $this->jsonTable($list,$userData['total']);
    }

    /**
     * @param $url
     * @param $name
     * @param $filter
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public static function getMongoDb($name,$filter){
        $manager = new \MongoDB\Driver\Manager(env('MONGOAPI'));
        $query   = new \MongoDB\Driver\Query($filter);
        return $manager->executeQuery($name, $query)->toArray();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exchange(){

        $list['stime'] = date("Y-m-d",strtotime("-7 day"));
        $list['etime'] = date("Y-m-d",time());
        return view('admin.hall.weekreward.exchange',['list'=>$list]);
    }


    public function exchangeData(Request $request){
        $uid = $request->get('uid',0);
        $stime = $request->get('stime',date("Y-m-d",strtotime("-7 day")));
        $etime = $request->get('etime',date("Y-m-d",time()));
        $limit = $request->get('limit',10);
        $stime = strtotime($stime);
        $etime = strtotime($etime)+86400;
        $model = TmpExchangeResultModel::query();
        $model->whereBetween('update_time',[$stime,$etime]);
        if (!empty($uid)){
            $model->where('uid',$uid);
        }
        $data = $model->paginate($limit)->toArray();
        $ids = [];
        $list = [];
        foreach ($data['data'] as $key =>$val) {
            $ids[] = $val['uid'];
            $list[$key]['uid']         = $val['uid'];
            $list[$key]['coins']       = round(toRmb($val['coins']),3);
            $list[$key]['update_time'] = date("Y-m-d H:i:s",$val['update_time']);
        }

        $userModel  = TmpDcusersModel::query();
        $usrData = $userModel->whereIn('uid',$ids)->select('uid','nickname')->pluck('nickname','uid')->toArray();
        foreach ($list as $key => $val){
            $list[$key]['nickname'] = $usrData[$val['uid']] ?? '';
        }
        return $this->jsonTable($list,$data['total']);
    }



}
