<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/20 19:52
 * +------------------------------
 */

namespace App\Repositories;
use App\Models\SysActivityPayModel;

/**
 * 充值活动
 * Class SysConfigRepository
 * @package App\Repositories
 */
class SysActivityPayRepository extends BaseRepository
{
    /**
     * 获取生效或的充值活动
     * @return array
     */
    public static function getActivePayList()
    {
        $time = time();
        $data = SysActivityPayModel::query()
            ->where('status',1)
            ->where('start_time','<=',$time)
            ->where('end_time','>=',$time)
            ->get()->toArray();
        return $data;
    }
    /**
     * 获取当前生效的活动一条记录
     * @return array|\Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getActivePay(){
        $data = self::getActivePayList();
        if($data){
            $data = current($data);
        }
        return $data;
    }
}