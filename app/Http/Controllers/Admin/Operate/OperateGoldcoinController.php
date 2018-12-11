<?php

namespace App\Http\Controllers\Admin\Operate;

use App\Models\UserMoneyUpdateModel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OperateGoldcoinController extends Controller
{
    /**
     * 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.operate.goldcoin.index');
    }

    /**
     * 列表数据获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $uid = $request->get('uid', 0);
        $model = UserMoneyUpdateModel::query();
        if ($uid) {
            $model->where('uid', $uid);
        }
        $limit = $request->get('limit', 10);
        $res = $model->orderBy('id', 'desc')->paginate($limit)->toArray();
        return $this->jsonTable($res['data'], $res['total'], 0, '正在请求中...');
    }

    /**
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $typeName = [
            'addcoins' => '加金币',
            'reducecoins' => '减金币'
        ];
        return view('admin.operate.goldcoin.create', compact('typeName'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request)
    {
        $type = $request->get('type', '');
        if (empty($type)) {
            return redirect(route('admin.goldcoin'))->with(['status' => '修改类型不能为空']);
        }
        $param = [
            'cmd' => $type,
            'value' => (int)$request->get('value', 0),
            'uid' => (int)$request->get('uid', 0)
        ];
        $url = config('server.server_api') . '/gm';
        $res = (new Client())->request('POST', $url, ['body' => http_build_query(['data' => json_encode($param)])])->getBody()->getContents();
        $res = json_decode($res, true);
        if ($res['code'] == 0) {
            $data = $request->all();
            $data['type'] = $type == 'addcoins' ? 1 : 2;
            $data['auth'] = Auth::user()->username;
            if (UserMoneyUpdateModel::create($data)) {
                return redirect(route('admin.goldcoin'))->with(['status' => '金币修改成功']);
            }
            return redirect(route('admin.goldcoin'))->with(['status' => '金币修改失败']);
        }

        return redirect(route('admin.goldcoin'))->with(['status' => '系统错误']);
    }

}
