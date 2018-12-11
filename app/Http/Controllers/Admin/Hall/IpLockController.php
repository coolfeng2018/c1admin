<?php

namespace App\Http\Controllers\Admin\Hall;

use App\Models\TmpIpLockModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class IpLockController extends Controller
{
    protected $type = [
        1 => '禁止'
    ];


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.hall.iplock.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $ip   = $request->get('lock_data','');
        $limit    = $request->get('limit',10);

        $model = TmpIpLockModel::query();
        if ($ip){
            $model->where('lock_data',$ip);
        }

        $model->orderBy('op_time','desc');
        $data = $model->paginate($limit)->toArray();
        $total = $data['total'];
        $data  = $data['data'];

        return $this->jsonTable($data,$total);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $type = $this->type;
        return view('admin.hall.iplock.create',['type' => $type]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'lock_data'             => 'required|string',
        ]);
        $ip     = $request->get('lock_data','');
        $memo = $request->get('memo','');

        $model = TmpIpLockModel::query();
        $rest = $model->where('lock_data',$ip)->where('lock_status',1)->first();
        if ($rest){
            return $this->json([],1,'ip已存在');
        }
        $data = [
            'lock_data'     => $ip,
            'memo'          => $memo,
            'lock_status'   => 1,
            'op_name'       => Auth::user()->username,
            'op_time'       => time()
        ];
        $rest = TmpIpLockModel::query()->insert($data);
        if (!$rest){
            return $this->json([],1,'添加失败');
        }
        return $this->json([],0,'添加成功');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request){
        $type = $this->type;
        $id    = $request->get('id',0);
        $model = TmpIpLockModel::query();
        $data  = $model->where('id',$id)->first();
        return view('admin.hall.iplock.edit',['data'=>$data,'type'=>$type]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(Request $request){
        $id            = $request->get('id',0);
        $lock_data     = $request->get('lock_data','');
        $lock_status   = $request->get('status',1);
        $memo          = $request->get('memo','');
        $data = array(
            'lock_data'    => $lock_data,
            'lock_status'  => $lock_status,
            'memo'         => $memo,
            'op_name'      => Auth::user()->username,
        );
        $rest = TmpIpLockModel::query()->where('id',$id)->update($data);
        if (!$rest){
            return $this->json([],1,'修改失败');
        }
        return $this->json([],0,'添加成功');

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request){
        $id    = $request->get('id',0);
        $status = $request->get('status',0);
        $lock_status = $status ? 0:1;
        $data['lock_status'] = $lock_status;
        $rest  = TmpIpLockModel::query()->where('id',$id)->update($data);
        if (!$rest){
            return $this->json([],1,'更改修改');
        }
        return $this->json([],0,'更改成功');
    }


}
