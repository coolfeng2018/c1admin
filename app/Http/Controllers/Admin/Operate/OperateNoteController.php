<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\DataUserHeadModel;
use App\Repositories\SendRepository;
use App\Repositories\DataUserHeadRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OperateNoteController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.operate.note.index');
    }

    /**
     * 短信列表获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $list = [];
        $note = app(SendRepository::class)->apiNoteServiceList();
        if($note){
            foreach ($note['options'] as $key => $value){
                $list[$key]['options'] = $value;
                $list[$key]['status'] = $note['curr_method']==$value ? '<span style="color: red">生效</span>' : '<span>未生效</span>';
            }
        }
        return $this->jsonTable($list,count($list),0,'正在请求中...');
    }

    /**
     * 设置生效短信渠道
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function set(Request $request){
        $method = $request->get('options','');
        if($method){
            $note = app(SendRepository::class)->apiNoteSet($method);
            if($note){
                return $this->json('',0,'设置成功!!!');
            }
        }
        return $this->json('',1,'设置失败!!!');
    }

}
