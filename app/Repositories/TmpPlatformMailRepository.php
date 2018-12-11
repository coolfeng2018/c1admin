<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/9/20 19:52
 * +------------------------------
 */

namespace App\Repositories;
use App\Models\TmpPlatformMailModel;
use Illuminate\Support\Facades\Log;

/**
 * 邮件
 * Class SysConfigRepository
 * @package App\Repositories
 */
class TmpPlatformMailRepository extends BaseRepository
{
    /**
     * 玩家发送邮件
     * @param $uid 用户id
     * @param $title 邮件标题
     * @param $content 邮件内容
     * @param int $mailType 邮件类型
     * @param array $attachList 赠送道具
     * @param int $coins 赠送金币
     * @return bool
     */
    public static function sendEmail($uid,$title,$content,$mailType=2,$attachList=[],$coins=0){
        if(empty($uid) || empty($title)){
            return false;
        }
        $range = is_array($uid) ? implode(',',$uid) : $uid;
        $param = [
            'range'=>$range,
            'title'=>$title,
            'content'=>$content,
            'mail_type'=>$mailType,
            'attach_list'=>json_encode($attachList,JSON_UNESCAPED_UNICODE),
            'status'=>TmpPlatformMailModel::$MAIL_STATUS_ISTOBE,
            'op_user'=>'system',
            'coins'=>$coins,
        ];
        $ret = TmpPlatformMailModel::create($param);
        if($ret){
            //调用发送邮件接口
            $mail = [
                'cmd' => 'notifynewmail',
                'range' => $range,
                'mail_type' => $mailType
            ];
            $data = self::apiCurl(config('server.server_api').'/mail',$mail,'POST','www');
            if($data){
                Log::info(__METHOD__.'send mail res :'.json_encode($data,JSON_UNESCAPED_UNICODE));
                return true;
            }
        }
        Log::info(__METHOD__.'send mail error :'.$ret);
        return false;
    }
}