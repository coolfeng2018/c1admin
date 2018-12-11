<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/26 15:03
 * +------------------------------
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 用户配置
 * Class SysUserExchangeModel
 * @package App\Models
 */
class SysUserExchangeModel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_user_exchange';

    //#此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';

    protected $fillable = [
        'method',
        'keep_money',
        'min_money',
        'max_money',
        'status',
        'thumb'
    ];
    /**
     * 追加字段
     * @var array
     */
    protected $appends = ['method_name', 'status_name'];

    /**
     * 支付方式
     * @var array
     */
    public static $method = [
        0 => '支付宝',
        1 => '银行卡',
    ];

    /**
     * 状态
     * @var array
     */
    public static $status = [
        1 => '上线',
        2 => '下线',
    ];

    /**
     * 取得名称
     * @param $value
     * @return mixed|string
     */
    public function getMethodNameAttribute($value)
    {
        return isset(self::$method[$this->method]) ? self::$method[$this->method] : '???';
    }


    /**
     * 取得状态名称
     * @param $value
     * @return mixed|string
     */
    public function getStatusNameAttribute($value)
    {
        return isset(self::$status[$this->status]) ? self::$status[$this->status] : '???';
    }
}