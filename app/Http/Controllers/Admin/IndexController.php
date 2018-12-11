<?php

namespace App\Http\Controllers\Admin;

use App\Models\Icon;
use App\Models\OperationLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class IndexController extends Controller
{
    /**
     * 后台布局
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function layout()
    {
        $username = Auth::user()->username;
        return view('admin.layout', ['username'=>$username]);
    }

    /**
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index.index');
    }

    public function index1()
    {
        return view('admin.index.index1');
    }

    public function index2()
    {
        return view('admin.index.index2');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 数据表格接口
     */
    public function data(Request $request)
    {
        $model = $request->get('model');
        switch (strtolower($model)) {
            case 'user':
                $query = new User();
                break;
            case 'role':
                $query = new Role();
                break;
            case 'permission':
                $query = new Permission();
                $query = $query->where('parent_id', $request->get('parent_id', 0))->with('icon');
                break;
            default:
                $query = new User();
                break;
        }
        $res = $query->paginate($request->get('limit', 30))->toArray();
        return $this->jsonTable($res['data'],$res['total']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 所有icon图标
     */
    public function icons()
    {
        $icons = Icon::orderBy('sort', 'desc')->get();
        return $this->json($icons,0,'请求成功');
    }

    /**
     * 系统操作日志
     */
    public function opreateLog(Request $request){
        return view('admin.index.operatelog');
    }
    /**
     * 系统操作日志
     */
    public function opreateData(Request $request){
        $uid = $request->get('uid',0);
        $limit = $request->get('limit',30);
        $model = OperationLog::query();
        if (!empty($uid) && is_string($uid)){
            $model->where('user_name',$uid);
        }
        if (!empty($uid) && is_int($uid)){
            $model->where('user_id',$uid);
        }
        $res  =  $model->orderBy('created_at','desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'],$res['total'],0,'正在请求中...');
    }


    /**
     * 菜单搜索
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function btnSearch(Request $request){
        $keywords = $request->get('keywords','');
        $res = $this->_formatTree($this->tree(),$keywords);
        return $this->json($res);
    }

    /**
     * 过滤树
     * @param $menus 菜单信息
     * @param string $filter 过滤关键字
     * @param int $level 层级
     * @param array $tmp 结果集
     * @return array
     */
    private function _formatTree($menus,$filter='',$level=1,&$tmp=[]){
        if(empty($menus)){
            return [] ;
        }
        $gate = app(Gate::class);
        foreach ($menus as $menu) {
            if($level <=2 && $filter && (strpos($menu['display_name'],$filter) !== false || strpos($menu['route'],$filter) !== false)){
                if($gate->check($menu['name'])){ //检查权限
                    $route = isset($menu['route']) && !empty($menu['route']);
                    $tmp[$menu['id']] = [
                        'display_name'=>str_repeat('&nbsp;&nbsp;',$level).'┣☛'.$menu['display_name'],
                        'host'=> $route ? URL::route($menu['route']) : '',
                        'selected_name'=> $menu['display_name'],
                        'route'=> $route ? $menu['route'] : '' ,
                        'level'=>$level,
                    ];
                };
            }
            if(isset($menu['_child']) && !empty($menu['_child'])){
                $this->_formatTree($menu['_child'],$filter,$level+1,$tmp);
            }
        }
        return $tmp;
    }
}
