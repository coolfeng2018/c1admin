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
use App\Models\TmpMessageModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

/**
 * 邮件
 * Class SysConfigRepository
 * @package App\Repositories
 */
class TmpMessageRepository extends BaseRepository
{
    const CUSTOMER_ID = 888888;

    /**
     * 获取列表
     * @param $uid
     * @param int $status
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getList($uid,$status=-1,$page=1,$size=10){
        $where = "" ;
        if($uid > 0 ){
            $where .= ' AND b.FromUid = '.$uid;
        }
        if($status >= 0 ){
            $where .= ' AND b.reback = '.$status;
        }
        $offset = ( $page -1 ) * $size ;
        $table = app(TmpMessageModel::class)->getTable();
        $customer_id = self::CUSTOMER_ID;
        $sql = "SELECT b.*, a.maxid FROM ( SELECT `FromUid`, MAX(`MessageId`) AS maxid FROM {$table} WHERE `FromUid`!={$customer_id} GROUP BY `FromUid` ) AS a,{$table} AS b WHERE a.maxid = b.MessageId {$where} ORDER BY  b.reback ASC,a.maxid DESC LIMIT {$size} OFFSET {$offset};";
        $data = DB::connection(config('constants.MYSQL_ONE_BY_ONE'))->select(DB::raw($sql));
        $ids = $tmp = [];
        if($data){
            $redisKey = config('cacheKey.REDIS_CUSTOMER_FLAG');
            foreach ($data as $item) {
                $ids[] = $item->FromUid;
                $tmp[$item->FromUid] = $item;
                if($item->FromUid != $customer_id && $item->reback == 0 ){
                    Redis::hmset($redisKey,$item->FromUid,$item->MessageId);
                }
            }
        }
        if($ids){
            $users = self::_getCustomerList($ids);
            if($users){
                foreach ($users as $user) {
                    if(isset($tmp[$user->uid])){
                        $tmp[$user->uid]->updatetime = $user->time;
                    }
                }
            }
            unset($users,$ids,$data);
        }
        return array_values($tmp);
    }

    /**
     * 获取总数
     */
    public function getTotle(){
        $table = app(TmpMessageModel::class)->getTable();
        $sql = "SELECT count(b.MessageId) AS totle FROM ( SELECT `FromUid`, MAX(`MessageId`) AS maxid FROM {$table} GROUP BY `FromUid` ) AS a,{$table} AS b WHERE a.maxid = b.MessageId;";
        $data = DB::connection(config('constants.MYSQL_ONE_BY_ONE'))->select(DB::raw($sql));
        return $data[0]->totle ?? 0 ;
    }

    /**
     * 回去最后回复列表
     * @param array $ids
     * @return array
     */
    private  function _getCustomerList($ids = []){
        if($ids){
            $sql = "select `uid`,`time` from `customer` where uid in(".implode(',',$ids).");";
            return DB::connection(config('constants.MYSQL_ONE_BY_ONE'))->select(DB::raw($sql));
        }
        return [] ;
    }
}