<?php
namespace App\Http\Controllers;

use App\Library\Tools\Upload;
use App\Traits\Msg;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    use Msg;

    /**
     * 图片上传处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImg(Request $request)
    {
        $file = $request->file('file');
        $data = Upload::curlFile($file, 'img');
        return $this->json($data,0,'上传成功');
    }
}