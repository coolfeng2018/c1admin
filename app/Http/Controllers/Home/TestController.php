<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 19:47
 * +------------------------------
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * 测试 专用  - TODO：不可删
 * Class TestController
 * @package App\Http\Controllers\Home
 */
class TestController extends Controller
{

    public function index(Request $request)
    {

        Log::info($request->input());

        echo '---------------' . PHP_EOL;


        Log::info(json_decode($request->post('data'), true));
    }

}