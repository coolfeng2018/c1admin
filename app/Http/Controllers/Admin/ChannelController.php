<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysBannerModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $positions = SysBannerModel::get();

        return view('admin.channel.index');
    }

    public function data(Request $request)
    {
        $model = SysBannerModel::query();

//        if ($request->get('position_id')){
////            $model = $model->where('position_id',$request->get('position_id'));
////        }
////        if ($request->get('title')){
////            $model = $model->where('title','like','%'.$request->get('title').'%');
////        }
///
        $res = $model->orderBy('id','desc')
            ->paginate($request->get('limit',30))->toArray();

        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //所有广告位置
//        $positions = Position::orderBy('sort','desc')->get();
        $methods = SysBannerModel::$method;
        $jumpName = SysBannerModel::$JumpName;
        return view('admin.channel.create',compact('methods','jumpName'));
    }

    /**
     * 参数验证
     * @param $request
     * @return array
     */
    private function _validate($request){
        $messages = [
            'channel.required'    => '渠道名是必填的',
            'size.required'    => 'KEY是必填的'
        ];
        return $this->validate($request,[
            'channel'  => 'required|string',
            'channel_key'  => 'required|string',
        ],$messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->_validate($request);
        $data = $request->all();
        $bannerData['channel'] = isset($data['channel']) ? $data['channel'] : '';
        $bannerData['channel_key'] = isset($data['channel_key']) ? $data['channel_key'] : '';

        $bannerData['pic_one'] = isset($data['pic_one']) ? $data['pic_one'] : '';
        $bannerData['pic_one_type'] = isset($data['pic_one_type']) ? $data['pic_one_type'] : 1;
        $bannerData['pic_one_url'] = $data['pic_one_type'] == 4 ? (isset($data['pic_one_jump']) ? $data['pic_one_jump'] : '') : (isset($data['pic_one_url']) ? $data['pic_one_url'] : '');

        $bannerData['pic_two'] = isset($data['pic_two']) ? $data['pic_two'] : '';
        $bannerData['pic_two_type'] = isset($data['pic_two_type']) ? $data['pic_two_type'] : 1;
        $bannerData['pic_two_url'] = $data['pic_two_type'] == 4 ? (isset($data['pic_two_jump']) ? $data['pic_two_jump'] : '') : (isset($data['pic_two_url']) ? $data['pic_two_url'] : '');

        $bannerData['pic_three'] = isset($data['pic_three']) ? $data['pic_three'] : '';
        $bannerData['pic_three_type'] = isset($data['pic_three_type']) ? $data['pic_three_type'] : 1;
        $bannerData['pic_three_url'] = $data['pic_three_type'] == 4 ? (isset($data['pic_three_jump']) ? $data['pic_three_jump'] : '') : (isset($data['pic_three_url']) ? $data['pic_three_url'] : '');

        if (SysBannerModel::create($bannerData)){
            return redirect(route('admin.channel'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.channel'))->with(['status'=>'系统错误']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advert = SysBannerModel::findOrFail($id);
        $methods = SysBannerModel::$method;
        $jumpName = SysBannerModel::$JumpName;
        return view('admin.channel.edit',compact('advert','methods', 'jumpName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->_validate($request);
        $data = $request->all();

        $bannerData['channel'] = isset($data['channel']) ? $data['channel'] : '';
        $bannerData['channel_key'] = isset($data['channel_key']) ? $data['channel_key'] : '';

        $bannerData['pic_one'] = isset($data['pic_one']) ? $data['pic_one'] : '';
        $bannerData['pic_one_type'] = isset($data['pic_one_type']) ? $data['pic_one_type'] : 1;
        $bannerData['pic_one_url'] = $data['pic_one_type'] == 4 ? (isset($data['pic_one_jump']) ? $data['pic_one_jump'] : '') : (isset($data['pic_one_url']) ? $data['pic_one_url'] : '');

        $bannerData['pic_two'] = isset($data['pic_two']) ? $data['pic_two'] : '';
        $bannerData['pic_two_type'] = isset($data['pic_two_type']) ? $data['pic_two_type'] : 1;
        $bannerData['pic_two_url'] = $data['pic_two_type'] == 4 ? (isset($data['pic_two_jump']) ? $data['pic_two_jump'] : '') : (isset($data['pic_two_url']) ? $data['pic_two_url'] : '');

        $bannerData['pic_three'] = isset($data['pic_three']) ? $data['pic_three'] : '';
        $bannerData['pic_three_type'] = isset($data['pic_three_type']) ? $data['pic_three_type'] : 1;
        $bannerData['pic_three_url'] = $data['pic_three_type'] == 4 ? (isset($data['pic_three_jump']) ? $data['pic_three_jump'] : '') : (isset($data['pic_three_url']) ? $data['pic_three_url'] : '');

        $advert = SysBannerModel::findOrFail($id);
        if ($advert->update($bannerData)){
            return redirect(route('admin.channel'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.channel'))->withErrors(['status'=>'系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return $this->json('',1,'请选择删除项');
        }
        if (SysBannerModel::destroy($ids)){
            return $this->json('',0,'删除成功');
        }
        return $this->json('',1,'删除失败');
    }
}
