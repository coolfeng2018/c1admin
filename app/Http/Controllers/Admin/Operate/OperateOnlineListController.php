<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\12\5 0005
 * Time: 16:43
 */

namespace App\Http\Controllers\Admin\Operate;
use App\Models\TmpDcusersModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * 在线列表
 * Class OperateOnlineListController
 * @package App\Http\Controllers\Admin\Operate
 */
class OperateOnlineListController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search_table_type = $request->input('table_type','-1');

        $table_type = config('game.table_list');
        $url = config('server.online_list_api');
        $result = BaseRepository::apiCurl($url,[],'POST','www');
        $onLineList = [];//在线列表
        $tmpUids = [];//在线用户id
        $hall_num = 0;//大厅人数
        if(isset($result['play_info_list']) && $result['play_info_list']){
            $onLineList = $result['play_info_list'];
            foreach ($onLineList as $val){
                $tmpUids[] = $val['uid'];
            }
            $data = TmpDcusersModel::query()
                ->select('first_buy_time','channel','created_time','ip','last_ip','device_id','uid')
                ->whereIn('uid',$tmpUids)->get()->toArray();
            if($data){
                foreach ($data as $k => $v){
                    $data[$v['uid']] = $v;
                    unset($data[$k]);
                }
            }

            //拼装其他数据
            foreach ($onLineList as $key => $value){
                $onLineList[$key]['table_type'] = isset($table_type[$value['table_type']]) ? $table_type[$value['table_type']] : '--';//所在位置
                $onLineList[$key]['coins'] = isset($value['coins']) ? $value['coins']/100 : 0;//金币【单位元】
                $onLineList[$key]['channel'] = isset($data[$value['uid']]['channel']) ? $data[$value['uid']]['channel'] : '--';//来源渠道
                $onLineList[$key]['created_time'] = isset($data[$value['uid']]['created_time']) ? $data[$value['uid']]['created_time'] : '';//注册时间
                $onLineList[$key]['ip'] = isset($data[$value['uid']]['ip']) ? $data[$value['uid']]['ip'] : '--';//注册ip
                $onLineList[$key]['last_ip'] = isset($data[$value['uid']]['last_ip']) ? $data[$value['uid']]['last_ip'] : '--';//上次登录ip
                $onLineList[$key]['device_id'] = isset($data[$value['uid']]['device_id']) ? $data[$value['uid']]['device_id'] : '--';//机器码
                $onLineList[$key]['first_buy_time'] = isset($data[$value['uid']]['first_buy_time']) ? $data[$value['uid']]['first_buy_time'] : '';//是否首次购买
                $onLineList[$key]['name'] = isset($value['name']) ? ($onLineList[$key]['first_buy_time'] ? '<b style="color: red;">'.$value['name'].'</b>' : $value['name']) : '游客';
                if($value['table_type']==0){
                    $hall_num += 1;
                }
                //搜索筛选
                if($search_table_type != -1 && isset($value['table_type']) && $value['table_type'] != $search_table_type){
                    unset($onLineList[$key]);
                }
            }
        }
        $online_num = count($onLineList);//在线人数
        $game_num = $online_num - $hall_num;//房间人数

        return view('admin.operate.onlinelist.index', [
            'data' => $onLineList,
            'table_type' => $table_type,
            'game_num' => $game_num,
            'hall_num' => $hall_num,
            'where' => [
                'table_type' => $search_table_type ?? ''
            ]
        ]);

        return view('admin.operate.onlinelist.index',compact('table_type'));
    }

    /**
     * 在线列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $table_type = config('game.table_list');
        $url = config('server.online_list_api');
        $result = BaseRepository::apiCurl($url,[],'POST','www');
        $onLineList = [];//在线列表
        $tmpUids = [];//在线用户id
        if(isset($result['play_info_list']) && $result['play_info_list']){
            $onLineList = $result['play_info_list'];
            foreach ($onLineList as $val){
                $tmpUids[] = $val['uid'];
            }
            $data = TmpDcusersModel::query()
                ->select('first_buy_time','channel','created_time','ip','last_ip','device_id','uid')
                ->whereIn('uid',$tmpUids)->get()->toArray();
            if($data){
                foreach ($data as $k => $v){
                    $data[$v['uid']] = $v;
                    unset($data[$k]);
                }
            }

            //拼装其他数据
            foreach ($onLineList as $key => $value){
                $onLineList[$key]['table_type'] = isset($table_type[$value['table_type']]) ? $table_type[$value['table_type']] : '--';//所在位置
                $onLineList[$key]['coins'] = isset($value['coins']) ? $value['coins']/100 : 0;//金币【单位元】
                $onLineList[$key]['channel'] = isset($data[$value['uid']]['channel']) ? $data[$value['uid']]['channel'] : '--';//来源渠道
                $onLineList[$key]['created_time'] = isset($data[$value['uid']]['created_time']) ? $data[$value['uid']]['created_time'] : '';//注册时间
                $onLineList[$key]['ip'] = isset($data[$value['uid']]['ip']) ? $data[$value['uid']]['ip'] : '--';//注册ip
                $onLineList[$key]['last_ip'] = isset($data[$value['uid']]['last_ip']) ? $data[$value['uid']]['last_ip'] : '--';//上次登录ip
                $onLineList[$key]['device_id'] = isset($data[$value['uid']]['device_id']) ? $data[$value['uid']]['device_id'] : '--';//机器码
                $onLineList[$key]['first_buy_time'] = isset($data[$value['uid']]['first_buy_time']) ? $data[$value['uid']]['first_buy_time'] : '';//是否首次购买
                $onLineList[$key]['name'] = isset($value['name']) ? ($onLineList[$key]['first_buy_time'] ? '<b style="color: red;">'.$value['name'].'</b>' : $value['name']) : '游客';
            }
        }

        return $this->jsonTable($onLineList,count($onLineList),0,'正在请求中...');
    }
}