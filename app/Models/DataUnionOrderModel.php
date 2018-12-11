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
 * 银联订单信息
 * Class DataRankBoard
 * @package App\Models
 */
class DataUnionOrderModel extends BaseModel
{
    protected $table = 'data_union_order';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['uid', 'order_id', 'way', 'bank_user_name', 'bank_account', 'money', 'give_money', 'o_desc', 'inner_order_id', 'o_status', 'op_name', 'updated_at'];

    /**
     * 追加非表中属性
     * @var array
     */
    protected $appends = ['way_str','o_status_str'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * way类型
     * @var array
     */
    public static $waysArr = [
        0 => '银行卡',
        1 => '支付宝',
        2 => '人工订单',
    ];

    /**
     * 状态类型
     * @var array
     */
    public static $oStatusArr = [
        0 => '审核中',
        1 => '已拒绝',
        2 => '已关闭',
        3 => '已完成',
    ];

    /**
     * 取得way类型中文名
     * @return mixed|string
     */
    public function getWayStrAttribute()
    {
        $value = isset($this->attributes['way']) ? $this->attributes['way'] : '' ;
        return isset(self::$waysArr[$value]) ? self::$waysArr[$value] : '';
    }

    /**
     * 取得状态类型中文名
     * @return mixed|string
     */
    public function getOStatusStrAttribute()
    {
        $value = isset($this->attributes['o_status']) ? $this->attributes['o_status'] : '' ;
        return isset(self::$oStatusArr[$value]) ? self::$oStatusArr[$value] : '';
    }
}