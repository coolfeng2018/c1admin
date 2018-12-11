<?php

namespace App\Http\Controllers\Admin\Store;
use App\Http\Controllers\Controller;
use App\Models\TmpStoreResultModel;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;

class DdzStoreController extends Controller{

    private static $list = [
        'ddz_junior' => '斗地主新手场 ',
        'ddz_normal' => '斗地主普通场 ',
    ];

    /**
     * 抽水数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataList(){
        return view('admin.store.ddzstore.list',['list' => self::$list]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request){
        $robot_type = $request->get('grade','ddz_junior');
        $limit = $request->get('limit',10);
        $model = TmpStoreResultModel::query();
        $data  = $model->where('robot_type',$robot_type)->orderBy('modified_time','desc')->paginate($limit+1)->toArray();
        $data  = StoreRepository::assemble($data,$limit);
        return $this->jsonTable($data['data'],$data['total']);
    }

}
