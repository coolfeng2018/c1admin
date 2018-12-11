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
use App\Models\SysPayListsModel;

/**
 * 支付列表
 * Class SysConfigRepository
 * @package App\Repositories
 */
class SysPayListsRepository extends BaseRepository
{
    /**
     * 获取生效的支付列表
     * @return array
     */
    public static function getActivePayLists()
    {
        $list = [];
        $data = SysPayListsModel::query()
            ->where('o_status',2)
            ->get(['id','pay_name','pay_channel']);
        if($data){
            foreach ($data as $item) {
                $list[$item->id] = $item->pay_name."({$item->pay_channel})";
            }
        }
        return $list;
    }
    /**
     * 获取指定类型的支付配置信息(limit 1 )
     * @param string $payWay 大类
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getActivePaysByType($payWay='')
    {
        if(empty($payWay)){
            return [] ;
        }
        $data = SysPayListsModel::query()
            ->where('o_status',2)
            ->where('pay_way',$payWay)
            ->orderBy('updated_at','desc')
            ->first();
        return $data;
    }
}