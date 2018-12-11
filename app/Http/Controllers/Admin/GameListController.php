<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/10/25 15:33
 * +------------------------------
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SysGameListModel;
use App\Repositories\GameListRepository;
use Illuminate\Http\Request;

/**
 * 大厅列表配置
 * Class VipController
 * @package App\Http\Controllers\Admin
 */
class GameListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.gamelist.index');
    }

    public function data(Request $request)
    {
        $model = SysGameListModel::query();
        $res = $model->orderBy('position', 'asc')->paginate($request->get('limit', 30))->toArray();
        return $this->jsonTable($res['data'], $res['total'], 0, '正在请求中...');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gamelist.create',[
            'gameList' => config('game.game_list'),
            'shownType' => SysGameListModel::$shownType,
            'noticeType' => SysGameListModel::$noticeType,
            'status' => SysGameListModel::$status,
            'guide_status' => SysGameListModel::$guideStatusStr,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'position' => 'required|numeric',
            'game_type' => 'required|numeric',
            'shown_type' => 'required|numeric',
            'notice_type' => 'required|numeric',
            'status' => 'required|numeric',
            'guide_status' => 'required|numeric',
        ]);
        if (SysGameListModel::create($request->all())) {
            return redirect(route('admin.gamelist'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.gamelist'))->with(['status' => '系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gameListData = SysGameListModel::findOrFail($id);
        return view('admin.gamelist.edit', [
            'gameList' => config('game.game_list'),
            'shownType' => SysGameListModel::$shownType,
            'noticeType' => SysGameListModel::$noticeType,
            'status' => SysGameListModel::$status,
            'guide_status' => SysGameListModel::$guideStatusStr,
            'gameListData' => $gameListData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'position' => 'required|numeric',
            'game_type' => 'required|numeric',
            'shown_type' => 'required|numeric',
            'notice_type' => 'required|numeric',
            'status' => 'required|numeric',
            'guide_status' => 'required|numeric',
        ]);
        $advert = SysGameListModel::findOrFail($id);
        if ($advert->update($request->all())) {
            return redirect(route('admin.gamelist'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.gamelist'))->withErrors(['status' => '系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return $this->json('', 1, '请选择删除项');
        }
        if (SysGameListModel::destroy($ids)) {
            return $this->json('', 0, '删除成功');
        }
        return $this->json('', 1, '删除失败');
    }

    /**
     * 发送配置
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {

        $flag = GameListRepository::uploadGameListConfig();

        if ($flag == GameListRepository::SUCCESS_FLAG) {
            return $this->json('', 0, '发送配置成功');
        } else {
            return $this->json('', 1, '发送配置失败');
        }
    }

}