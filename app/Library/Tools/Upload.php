<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/27 0027
 * Time: 17:15
 */

namespace App\Library\Tools;

use Illuminate\Support\Facades\Log;

class Upload
{
    /**
     * 文件上传
     * @param $fileObj 文件对象
     * @param string $dir 存储目录
     * @return array
     */
    public static function curlFile($fileObj, $dir = 'img')
    {
        header('content-type:text/html;charset=utf8');
        $fileData = file_get_contents($fileObj->getRealPath());
        $file = './static/' . time() . rand(1000, 9999) . '.' . $fileObj->getClientOriginalExtension();
        $ret = file_put_contents($file, $fileData);
        if ($ret) {
            $upload_key = config('server.file_upload_key');
            $fileBaseName = basename($file);
            $key = md5($fileBaseName . $dir . $upload_key);
            $upload_url = config('server.file_upload_address');
            $params = [
                'file' => new \CurlFile(realpath($file)),
                'type' => $dir,
                'key' => $key,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $upload_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $rest = curl_exec($ch);
            curl_close($ch);
            $rest = json_decode($rest, true);
            unlink($file);
            if ($rest['code'] != 0) {
                Log::info(__METHOD__ . ' http curl response : ' . json_encode($rest));
                return ['code' => $rest['code'], 'msg' => $rest['msg']];
            } else {
                $data = [
                    'code' => 0,
                    'msg' => '上传成功',
                    'newfile' => $rest['newfile'],
                    'path' => $dir . '/' . $rest['newfile'],
                    'url' => $upload_url . $rest['url']
                ];
                return $data;
            }
        }
        return ['code' => 9, 'msg' => '写入文件失败'];
    }
}

