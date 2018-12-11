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
use App\Models\DataUnionOrderModel;
use App\Models\SysPayListsModel;

/**
 * 银行卡转账订单列表
 * Class SysConfigRepository
 * @package App\Repositories
 */
class DataUserHeadRepository extends BaseRepository
{
    /**
     * 更新服务器玩家头像
     * @param $uid 用户
     * @param string $headIcon 头像名称
     * @param string $desc 备注信息
     * @return bool
     */
    public static function updateServerHead($uid,$headIcon='',$desc=''){
        $params = [
            "icon"=>$headIcon,
            "uid"=> $uid
        ];
        $data = self::apiCurl(config('server.server_api').'/upload_icon',$params);
        if($data){
            return true ;
            //发送邮件通知
//            $title = "头像更换审核";
//            $content = empty($desc) ? "亲,你的头像更换申请已审核通过.." : $desc;
//            return TmpPlatformMailRepository::sendEmail($uid,$title,$content);
        }
        return false;
    }
}