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
 * 订单数据统计
 * Class OrderModel
 * @package App\Models
 */
class OrderModel extends BaseModel
{
    protected $table      = 'order';
    protected $connection = '';

    public function __construct(array $attributes = [])
    {
        $this->connection = config('constants.MYSQL_PAYMENT');
    }
//    protected $fillable = ['order_id','amount','uid','product_id','create_time','paid_time','channel_order','status','payment_channel','channel','extra'];


    protected $appends = ['status_name'];
    /**
     * 支付类别列表
     * @return array
     */
    public static function payType(){
        return  array(
            'z' => '所有',
            'alipay'=> '支付宝',
            'wx' => '微信支付',
            'qq' => 'QQ支付',
            'union' => '银联',
            'gm' => '人工订单'
        );
    }

    /**
     *  渠道列表
     * @return array
     */
    public static function channel(){
        return array(
            'z'       => '所有',
            'ios'     => 'ios',
            'android' => '安卓',
            'window'  => '测试专用',
        );
    }

    /**
     *  支付状态
     * @return array
     */
    public static function payStatus(){
        return array(
            'z'     => '所有',
            '0'     => '已下单',
            '1'     => '已支付未处理',
            '2'     => '已支付已处理完成',
            '3'     => '已废弃'
        );
    }


    /**
     * 获取支付名称S
     * @param type $paymentChannel
     * @return string
     */
    public static function getPaymentName($paymentChannel){
        switch ($paymentChannel) {
            case 'xiaoqian_qq':
            case 'qq':
                $name = "QQ支付";
                break;
            case 'xiaoqian_alipay':
            case 'alipay':
                $name = "支付宝";
                break;
            case 'xiaoqian_wx':
            case 'wx':
                $name = "微信支付";
                break;
            case 'xiaoqian_union':
            case 'union':
                $name = '银联支付';
                break;
            case 'gm':
                $name = '人工订单';
                break;
            default:
                $name = '未知';
                break;
        }
        return $name;
    }

    public function getStatusNameAttribute()
    {
        $value = isset($this->attributes['status']) ? $this->attributes['status'] : '' ;
        return self::payStatus()[$value] ? self::payStatus()[$value] : '';
    }

    /**
     * 支付结果
     * @param type $status
     * @return string
     */
    /*public static function getPayResult($status) {
        switch ($status) {
            case 0:
                $msg = "已下单";
                break;
            case 1:
                $msg = "已支付未处理";
                break;
            case 2:
                $msg = "已支付已处理完成";
                break;
            case 3:
                $msg = "已废弃";
                break;
        }
        return $msg;
    }*/


}