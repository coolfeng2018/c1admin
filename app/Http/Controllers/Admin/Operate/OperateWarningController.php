<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 16:14
 */

namespace App\Http\Controllers\Admin\Operate;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataWarningModel;
class OperateWarningController extends Controller
{

    public function index(){
        $data = config('game.table_list');
        return view('admin.operate.warning.index', ['list' => $data]);
    }

    public function data(Request $request){
        $limit = $request->get('limit', 10);
        $model =   $model = DataWarningModel::query();
        $data =  $model->paginate($limit)->toArray();
        return $this->jsonTable($data['data'], $data['total']);
    }

}