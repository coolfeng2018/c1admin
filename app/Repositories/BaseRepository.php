<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/20 9:40
 * +------------------------------
 */

namespace App\Repositories;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * 基类
 * Class BaseRepository
 * @package App\Repositories
 */
abstract class BaseRepository
{

    const SUCCESS_FLAG = 'scuess';
    const ERROR_FLAG = 'error';

    /**
     * CURL请求 TODO:发送配置到服务端  -》 弃用
     * @param $url
     * @param $params
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function curl($url, $params)
    {
        Log::info(__METHOD__ . ' Http client curl request params : ' . $params);

        $options = [
            'form_params' => ['data' => $params],
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
        ];
        try{
            $resp = (new Client())->request('POST', $url, $options)->getBody()->getContents();
            Log::info(__METHOD__ . ' http curl response : ' . $resp);
            return $resp;

        }catch (\Exception $e){

            Log::info(__METHOD__ . 'request:'.$url.',request error code:'.$e->getCode().', error msg : ' . $e->getMessage());

        }
        return false ;
    }

    /**
     * api 远程接口请求
     * @param $url 地址
     * @param $params 参数
     * @param string $method 方法
     * @param string $type 头类型
     * @param array $header 头参数
     * @return bool|mixed|string
     */
    public static function apiCurl($url, $params,$method='POST',$type='json',$header=[])
    {
        if($type == 'www'){
            $options = [
                'form_params' => ['data' => json_encode($params,JSON_UNESCAPED_UNICODE)],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ]
            ];
        }else{
            $options = [
                'json' => ($params),
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ];
        }

        //添加headers参数
        if(count($header)>0){
            $options['headers'] = array_merge($options['headers'],$header);
        }

        try{
            $data = (new Client())->request($method, $url,$options)->getBody()->getContents();

            if ($data) {
                $tmpData = json_decode($data, true);
                $data = $tmpData ? $tmpData : $data;
                if(isset($data['code']) && $data['code'] == 0){
                    if(isset($data['data'])){
                        if(!is_array($data['data'])) {
                            $data['data'] = json_decode($data['data'], 1);
                        }
                        return $data['data'];
                    }
                }
                return $data ;
                Log::info(__METHOD__ . 'request:'.$url.',request params:'.json_encode($params,JSON_UNESCAPED_UNICODE).', http response : ' . json_encode($data,JSON_UNESCAPED_UNICODE));
            }else{
                Log::info(__METHOD__ . ' http api curl response : null');
            }

        }catch (\Exception $e){
            Log::info(__METHOD__ . 'request:'.$url.',request error code:'.$e->getCode().', error msg : ' . $e->getMessage());
        }
        return false;
    }
}