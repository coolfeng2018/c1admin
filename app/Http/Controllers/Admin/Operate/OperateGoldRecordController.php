<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\TmpUserMoneyModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 流水数据
 * Class OperateGoldRecordController
 * @package App\Http\Controllers\Admin\Operate
 */
class OperateGoldRecordController extends Controller
{
    /**
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $goldReasonList = config('game.gold_reason_list');
        $tableList = config('game.table_list');
        return view('admin.operate.goldrecord.index',compact('goldReasonList','tableList'));
    }

    /**
     * 列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $uid = $request->get('uid',0);
        $reason = $request->get('reason','');
        $table = $request->get('table','');
        $stime = $request->get('stime',date("Y-m-d H:i:s",strtotime('-7 day')));
        $etime = $request->get('etime',date("Y-m-d H:i:s"),time());

        $limit = $request->get('limit',30);
        $model = TmpUserMoneyModel::query();
        if ($uid){
            $model->where('uid',$uid);
        }
        if($reason){
            $model->where('reason',$reason);
        }
        if($table){
            $model->where('table_type',$table);
        }
        if($stime){
            $model->where('time','>=',strtotime($stime));
        }
        if($etime){
            $model->where('time','<=',strtotime($etime));
        }
        $res  =  $model->orderBy('time','desc')->paginate($limit);
        if($res){
            $res = $this->getShowList($res)->toArray();
        }
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * 对展示数组进行处理
     * @param unknown $all
     * @return array
     */
    public function getShowList($all) {
        $goldReasonList = config('game.gold_reason_list');
        $tableList = config('game.table_list');
        foreach ($all as $k =>$v) {
            $v->rsn = isset($goldReasonList[$v->reason]) ? $goldReasonList[$v->reason]['cn'] : $v->reason;
            $v->table = isset($tableList[$v->table_type]) ? $tableList[$v->table_type] : $v->table_type;
            $v->optime = date('Y-m-d H:i:s',$v->time);
            $v->cur_num = $v->curr/100;
            if($v->game_type == 6){
                //捕鱼流水
                $v->chg_num = $v->op==100044 ? '+'.$v->value/100 : '-'.$v->value/100;
            }else{
                $v->chg_num = $v->op==1 ? '+'.$v->value/100 : '-'.$v->value/100;
            }
        }
        return $all;
    }
}
