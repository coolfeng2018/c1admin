<?php

namespace App\Http\Controllers\Admin\Store;
use App\Http\Controllers\Controller;
use App\Models\SysConfigModel;
use App\Models\TmpStoreResultModel;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;

class HhdzStoreController extends Controller{

    private static $list = [
        'hhdz_normal'=>'红黑大战普通场 ',
    ];

    /**
     *  红黑库存配置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $list['data'] = self::$list;
        $list['key'] = json_encode(array_keys($list['data']));
        $rest = SysConfigModel::getSysKeyExists(SysConfigModel::STORE_HHDZ_KEY);
        $data = array(
            'hhdz_normal' => $rest['hhdz_normal'] ?? [],
        );
        $data = StoreRepository::listData($list['data'],$data);
        return view('admin.store.hhdzstore.index',['data' => $data,'list' => $list]);
    }

    /**
     *  保存数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        $data = $request->get('data','');
        //$gameList = $request->get('list','');
        $list = [];
        foreach ($data as $key=>$val){
            $list[$key]['award_rate'] = is_numeric($val['award_rate']) ? $val['award_rate'] : 0;
            $list[$key]['award_warn'] = is_numeric($val['award_warn']) ? $val['award_warn'] : 0;
            $list[$key]['base_goal']  = is_numeric($val['base_goal'])  ? $val['base_goal']  : 0;
            $list[$key]['base_warn']  = is_numeric($val['base_warn'])  ? $val['base_warn']  : 0;
            $list[$key]['fee_rate']   = is_numeric($val['fee_rate'])   ? $val['fee_rate']   : 0;
            $list[$key]['tigger_rate']= is_numeric($val['tigger_rate'])? $val['tigger_rate']: 0;
            $list[$key]['lose_limit'] = is_numeric($val['lose_limit']) ? $val['lose_limit'] : 0;
            $list[$key]['special_rate'] = is_numeric($val['special_rate']) ? $val['special_rate'] : 0;
        }
        if (empty($list)){
            return $this->json([],1,'数据不能为空！');
        }
        if (SysConfigModel::saveSysVal(SysConfigModel::STORE_HHDZ_KEY, $list)) {
            return $this->json([],0,'保存成功!');
        }
        return $this->json([], 1,'保存失败！');
    }

    /**
     * 抽水数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataList(){
        return view('admin.store.hhdzstore.list',['list' => self::$list]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request){
        $robot_type = $request->get('grade','hhdz_normal');
        $limit = $request->get('limit',10);
        $model = TmpStoreResultModel::query();
        $data = $model->where('robot_type',$robot_type)->orderBy('modified_time','desc')->paginate($limit+1)->toArray();
        $data = StoreRepository::assemble($data,$limit);
        return $this->jsonTable($data['data'],$data['total']);
    }

    /**
     * 发送到服务器配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(){
        if (StoreRepository::sendConfig()) {
            return $this->json('', 0, '发送配置成功');
        }
        return $this->json('', 1, '发送配置失败');
    }

}
