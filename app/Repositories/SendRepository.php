<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: mike
 * +------------------------------
 * DateTime: 2018/10/20 19:52
 * +------------------------------
 */

namespace App\Repositories;

/**
 * 短息相关
 * Class SysConfigRepository
 * @package App\Repositories
 */
class SendRepository extends BaseRepository
{
    /**
     * 获取短信服务列表
     * @return bool|mixed
     */
    public function apiNoteServiceList(){
        $now = time();
        $header = [
            'sms-time' => $now,
            'sms-sign' => $this->getSign($now)
        ];
        $data = self::apiCurl(config('note.note_api').'/default_sms_sender',[],'GET','www',$header);
        if($data){
            return $data;
        }
        return false;
    }

    /**
     * 设置短信渠道生效
     * @param string $method
     * @return bool|mixed.
     */
    public function apiNoteSet($method=''){
        $now = time();
        $header = [
            'sms-time' => $now,
            'sms-sign' => $this->getSign($now),
            'sms-method' => $method
        ];
        $data = self::apiCurl(config('note.note_api').'/default_sms_sender',[],'POST','www',$header);
        if($data){
            return $data;
        }
        return false;
    }

    /**
     * 获取短信签名
     * @string now 时间戳
     * @return string sign
     */
    public function getSign($now){
        return strtolower(md5($now.config('note.note_secret')));
    }
}