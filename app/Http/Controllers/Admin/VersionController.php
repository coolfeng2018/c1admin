<?php

namespace App\Http\Controllers\Admin;

use App\Models\DataVersionModel;
use App\Models\TmpVersionListModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



/**
 * 热更新
 * Class PackageController
 * @package App\Http\Controllers\Admin
 */
class VersionController extends Controller
{

    /**
     * 版本管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.version.index');
    }

    public function data(Request $request)
    {
        $limit = $request->get('limit','10');
        $path = config('server.file_upload_url');
        $limit = $request->get('limit',$limit);

        $type = [1=>'安卓',2=>'ios',3=>'windows'];
        //$model = DataVersionModel::query();
        $model = TmpVersionListModel::query();
        $res = $model->orderBy('id', 'desc')
            ->select('id','version','update_type','game_code','is_public','ver_int','is_force','allow_channel','allow_version','release_time','status','platform','apk_update_url')
            ->paginate($limit)->toArray();
        foreach ($res['data'] as $key=>$val ) {
            $res['data'][$key]['allow_version'] = $val['allow_version']=='*'?'所有版本':$val['allow_version'];
            $res['data'][$key]['allow_channel'] = $val['allow_channel']=='*'?'所有渠道':$val['allow_channel'];
            $res['data'][$key]['is_force']      = $val['is_force']?'强更':'非强更';
            $res['data'][$key]['update_type']   = $val['update_type']?'热更':'整包更新';
            $res['data'][$key]['is_public']     = $val['is_public']=='*'?'是':'否';
            $res['data'][$key]['release_time']  = $val['release_time'];
            $arr = explode(',',$val['platform']);
            if (empty($arr)){
                continue;
            }
            $platform = '';
            foreach ($arr as $val){
                $platform .= $type[$val].',';
            }
            $res['data'][$key]['platform'] = $platform;
        }
        return $this->jsonTable($res['data'],$res['total'],0,'ok');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $list = array('Android' => 1,'ios'=>2,'windows'=>3);
        $date = date('Y-m-d H:i:s', time());
        $data = array(
            'version'         => '',
            'update_type'     => 1,
            'game_code'       => '',
            'is_public'       => '*',
            'is_force'        => 1,
            'allow_channel'   => '*',
            'deny_channel'    => '',
            'allow_version'   => '*',
            'deny_version'    => '',
            'game_info'       => '',
            'release_time'    => $date,
            'platform'        => '1,2,3',
            'is_update'       => 0,
            'status'          => 1,
            'channel'         => [1,2,3],
        );
        return view('admin.version.create',['date'=>$date,'data'=>$data,'list'=>$list]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'allow_version' => 'required|string',
            'allow_channel' => 'required|string',
            'is_public'     => 'required|string',
            'client'        => 'required|string',
            //'release_time'  =>'required|string',
            'version_num'   =>'required|string',
            'is_force'      =>'required|string',
            'update_type'   =>'required|string',
            //'game_info'     =>'required|string',
        ]);

        $app_update_url = '';
        if (empty($request->get('update_type','1'))){
            $app['android'] = $request->get('app_android','');
            $app['ios']     = $request->get('app_ios','');
            $app['windows'] = $request->get('app_windows','');
            $app_update_url = json_encode($app);
        }

        $date = date('Y-m-d H:i:s',time());
        $release_time = $request->release_time;//$this->toTime($request->release_time);
        $deny_channel = $request->deny_channel;
        $deny_version = $request->deny_version;
        $ver_int = self::implodeVer($request->version_num);
        $data = array(
          'version'         => $request->version_num,
          'update_type'     => $request->update_type,
          'game_code'       => $request->game_code,
          'is_public'       => $request->is_public,
          'ver_int'         => $ver_int,
          'created_time'    => $date,
          'is_force'        => $request->is_force,
          'allow_channel'   => $request->allow_channel,
          'deny_channel'    => ($deny_channel=='*')?'':$deny_channel,
          'allow_version'   => $request->allow_version,
          'deny_version'    => ($deny_version=='*')?'':$deny_version,
          'modified_time'   => $date,
          'game_info'       => $request->game_info,
          'description'     => $request->description,
          'size'            => $request->size ?? 0,
          'release_time'    => $release_time,
          'apk_update_url'  => $app_update_url,
          'platform'        => trim($request->client,','),
          'description'     => $request->description,
          'status'          => $request->status ?? 1,
        );


        if (TmpVersionListModel::insert($data)) {
            return redirect(route('admin.version'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.version'))->with(['status' => '系统错误']);
    }

    /**
     * @param $ver
     * @return bool|float|int
     */
    public static function implodeVer($ver) {
        $verArr = explode('.', $ver);
        $retVal = 0;
        $step = [100000000, 100000];
        if (count($verArr) != 3) {
            return false;
        }
        for ($i=0; $i<3; $i++) {
            if ($i == 2) {
                $retVal += $verArr[$i];
            } else {
                $retVal += $verArr[$i]*$step[$i];
            }
        }
        return $retVal;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $list = array('Android' => 1,'ios'=>2,'windows'=>3);
        $id = $request->get('id','');
        $data = TmpVersionListModel::query()->where('id',$id)->first()->toArray();
        //dd($data);

        $str = [];
        if ($data['game_info']){
            $channelStr = json_decode($data['game_info'],1);
            foreach ($channelStr as $key=>$val){
                $str[$key] = '';
                foreach ($val as $k=>$v){
                    $str[$key] .= $v['gameCode'].'项目配置地址'.$v['resources_url'].'/'.$v['manifest_res']. "<br>";
                }
            }
        }
        $app = array();
        if ($data['apk_update_url']){
            $app = json_decode($data['apk_update_url'],1);
        }


        $channet = explode(',',$data['platform']);
//        foreach ($list as $key=>$val){
//            $list[$key] = in_array($val,$channet)?$val:'';
//        }

        $data['channel'] = $channet;
        $data['is_update'] = 1;
        $data['release_time'] = $data['release_time'];// $this->toDate($data['release_time']);
        return view('admin.version.edit',['data'=>$data,'list'=>$list,'str' => $str,'app'=>$app,'date'=>$data['release_time']]);
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $id = $request->get('id','');
        $this->validate($request, [
            'allow_version' => 'required|string',
            'allow_channel' => 'required|string',
            'is_public'     => 'required|string',
            'client'        => 'required|string',
            'version_num'   => 'required|string',
            'is_force'      => 'required|string',
            'update_type'   => 'required|string',
        ]);

        $app_update_url = '';
        if (empty($request->get('update_type','1'))){
            $app['android'] = $request->get('app_android','');
            $app['ios']     = $request->get('app_ios','');
            $app['windows'] = $request->get('app_windows','');
            $app_update_url = json_encode($app);
        }

        $date = date('Y-m-d H:i:s',time());
        $release_time = $request->release_time;//$this->toTime($request->release_time);
       // $release_time= explode(' ',$date);

        $deny_channel = $request->deny_channel;
        $deny_version = $request->deny_version;
        $ver_int = self::implodeVer($request->version_num);
        $data = array(
            'version'         => $request->version_num,
            'update_type'     => $request->update_type,
            'is_public'       => $request->is_public,
            'ver_int'         => $ver_int,
            'is_force'        => $request->is_force,
            'allow_channel'   => $request->allow_channel,
            'deny_channel'    => ($deny_channel=='*')?'':$deny_channel,
            'modified_time'   => $date,
            'allow_version'   => $request->allow_version,
            'deny_version'    => ($deny_version=='*')?'':$deny_version,
            'game_info'       => $request->game_info,
            'release_time'    => $release_time,
            'apk_update_url'  => $app_update_url,
            'platform'        => trim($request->client,','),
            'description'     => $request->description,
            'status'          => $request->status ?? 1,
        );
        if (TmpVersionListModel::query()->where('id',$id)->update($data)) {
            return redirect(route('admin.version'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.version'))->with(['status' => '系统错误']);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return $this->json(['code' => 1, 'msg' => '请选择删除项']);
        }
        if (TmpVersionListModel::destroy($ids)) {
            return response()->json(['code' => 0, 'msg' => '删除成功']);
        }
        return response()->json(['code' => 1, 'msg' => '删除失败']);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $channelList = ['android','ios','windows'];
        $channel     = 'ios';                                                   //默认渠道
        $url         = config('server.packages_upload_url');  //上传URL
        $path        = config('server.packages_upload_dir');
        $dir = $path.$channel;                              //项目路径
        $fileName = $file -> getClientOriginalName();       //文件名称
        $version = basename($fileName,".zip");        //版本号
        $res = TmpVersionListModel::query()->select('id')->where('version',$version)->first();
        if ($res){
            return json_encode(['data'=>[],'code'=>3,'msg'=>'此版本已经存在']);
        }

        $resPath = '/src/game';
        $find_dir = $dir.'/'.$version.$resPath;            //查找
        if (move_uploaded_file($file -> getRealPath(), $dir.'/'.$fileName)){
            foreach ($channelList as $key=>$val){
                if ($channel == $val){
                    continue;
                }
                exec("cp {$dir}/{$fileName} -f {$path}{$val}",$arr,$status);
                unset($arr);
                if ($status != 0){
                    return json_encode(['data'=>[],'code'=>3,'msg'=>'系统错误']);
                }
            }

            foreach ($channelList as $val){
                exec("unzip -o {$path}{$val}/{$fileName} -d {$path}{$val}",$arr,$status);
                if ($status != 0){
                    return json_encode(['data'=>[],'code'=>3,'msg'=>'系统错误']);
                }
                unset($arr);
                unlink($path.$val.'/'.$fileName);
            }
            $list = $data = [];

            exec("cd {$find_dir} && find  | grep .manifest",$res,$status);
            foreach ($channelList as $channel){
                foreach ($res as $key=>$val){
                    $path = ltrim($val,'./');
                    $arr = explode('/',$path);
                    $list[$arr[0]]['gameCode'] = $arr[0];
                    $list[$arr[0]]['manifest_res'] = $resPath.'/'.$path;
                    $list[$arr[0]]['resources_url'] = $url.$channel.'/'.$version;
                }
                $list['lobby'] = array('gameCode' => 'lobby', 'manifest_res' => 'src/lobby/version.manifest', 'resources_url'=> $url.$channel.'/'.$version);
                $list['update'] = array('gameCode' => 'update', 'manifest_res' => 'src/update/version.manifest', 'resources_url'=> $url.$channel.'/'.$version);
                $data['list'][$channel] = $list;
            }
            $data['version'] = $version;
            return json_encode(['data'=>$data,'code'=>0,'msg'=>'ok']);
           // return $this->json($data, 0, 'ok');
        }

        return json_encode(['data'=>[],'code'=>3,'msg'=>'系统错误']);
    }


    /**
     * @param $date
     * @return false|int]
     */
    public function toTime($date){
        return strtotime($date);
    }

    /**
     * @param $time
     * @return false|string
     */
    public function toDate($time){
        return date('Y-m-d H:i:s',$time);
    }




}
