<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/9/19 11:14
 * +------------------------------
 */

namespace App\Models;

class SysPayListsModel extends BaseModel
{
    protected $table = 'sys_pay_lists';

    protected $fillable = ['pay_name', 'pay_channel', 'pay_way', 'money_list', 'is_diy', 'diy_max', 'diy_min', 'sort_id', 'pay_desc', 'o_status', 'o_activity', 'pay_info', 'op_name', 'updated_at'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = true;
    //#此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';
    //追加非表中属性
    protected $appends = ['is_diy_str','o_status_str','o_activity_str','pay_way_str'];

    /**
     * 状态 map
     * @var array
     */
    public static $statusArr = [
        1 => '不生效',
        2 => '生效中',
    ];
    /**
     * 金额 map
     * @var array
     */
    public static $diysArr = [
        0 => '固定金额',
        1 => '自定义金额',
    ];
    //自定义金额
    const PAY_DIY_RECHARGE_NUM = 1 ;

    /**
     * 支付方式 map
     * @var array
     */
    public static $payWaysArr = [
        'alipay' => '支付宝',
        'wx'     => '微信',
        'union'  => '银联',
        'unioncard'=> '银行卡转帐',
        'vip'=> 'VIP充值',
    ];
    //银联支付方式
    const PAY_WAY_UNIONCARD = 'unioncard';

    //VIP充值支付方式
    const PAY_WAY_VIP = 'vip';
    const PAY_WAY_VIP_NAME = 'vip充值';
    const PAY_WAY_VIP_CHANNEL = 'vip_channel';
    /**
     * 角标 map
     * @var array
     */
    public static $activitysArr = [
        '0' => '不推荐',
        '1' => '推荐',
    ];

    /**
     * 取得额外配置信息
     * @param $value
     * @return array|mixed
     */
    public function getPayInfoAttribute($value)
    {
        if($value){
            $value = $this->attributes['pay_info'] = is_array($value) ? (array)$value:json_decode($value,true);
        }
        return $value;
    }

    /**
     * 设置额外配置信息
     * @param $value
     * @return string
     */
    public function setPayInfoAttribute($value)
    {
        if($value){
            $value = $this->attributes['pay_info'] = is_array($value) ? json_encode($value,JSON_UNESCAPED_UNICODE) : $value ;
        }
        return $value;
    }
    /**
     * 取得状态中文名
     * @return mixed|string
     */
    public function getOStatusStrAttribute()
    {
        $value = isset($this->attributes['o_status']) ? $this->attributes['o_status'] : '' ;
        return isset(self::$statusArr[$value]) ? self::$statusArr[$value] : '';
    }
    /**
     * 取得推荐中文名
     * @return mixed|string
     */
    public function getOActivityStrAttribute()
    {
        $value = isset( $this->attributes['o_activity']) ?  $this->attributes['o_activity'] : '' ;
        return isset(self::$activitysArr[$value]) ? self::$activitysArr[$value] : '';
    }
    /**
     * 取得金额中文名
     * @return mixed|string
     */
    public function getIsDiyStrAttribute()
    {
        $value = isset( $this->attributes['is_diy']) ?  $this->attributes['is_diy'] : '' ;
        return isset(self::$diysArr[$value]) ? self::$diysArr[$value] : '';
    }
    /**
     * 取得支付方式中文名
     * @return mixed|string
     */
    public function getPayWayStrAttribute()
    {
        $value = isset($this->attributes['pay_way']) ? $this->attributes['pay_way'] : '' ;
        return isset(self::$payWaysArr[$value]) ? self::$payWaysArr[$value] : '';
    }
}