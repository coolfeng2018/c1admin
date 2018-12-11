<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/20 20:15
 * +------------------------------
 */

namespace App\Models;

/**
 * user_result
 * Class OrderModel
 * @package App\Models
 */
class TmpWidthdrawModel extends BaseModel
{
    protected $table      = 'withdraw';
    protected $connection = 'mysql_one_by_one';


    /**
     * 新增提现总额
     * @param array $uids
     * @return int
     */
    public function getWidthdrawSum($uids=[]){
        if(!$uids) return 0;
        $count = $this->where('Status',1)->whereIn('uid',$uids)->sum('Amount');
        return $count;
    }
}