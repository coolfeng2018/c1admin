<?php

namespace App\Models;


class WithdrawModel extends BaseModel
{
    protected $connection = 'mysql_one_by_one';

    protected $table      = 'withdraw';

    protected $fillable = ['WithdrawId','uid', 'Amount', 'CurrentBalance', 'Balance', 'WithdrawChannel', 'WithdrawInfo', 'IsRead', 'Status', 'CreateAt', 'UpdateAt'];

    /**
     * 追加非表中属性
     * @var array
     */
    protected $appends = ['status_name', 'WithdrawChannel_name', 'Fees'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;

    //状态
    public static $statusName = [
        '0' => '未处理',
        '1' => '已处理',
        '2' => '已拒绝',
        '3' => '已驳回'
    ];

    public static $WithdrawChannelName = [
        '0' => '支付宝',
        '1' => '银行',
        '2' => '微信'
    ];

    public function getFeesAttribute()
    {
        return isset($this->attributes['Amount']) ? $this->attributes['Amount'] * 0.02 : 0 ;
    }

    public function getStatusNameAttribute()
    {
        $value = isset($this->attributes['Status']) ? $this->attributes['Status'] : '' ;
        return isset(self::$statusName[$value]) ? self::$statusName[$value] : '';
    }


    public function getWithdrawChannelNameAttribute()
    {
        $value = isset($this->attributes['WithdrawChannel']) ? $this->attributes['WithdrawChannel'] : '' ;
        return isset(self::$WithdrawChannelName[$value]) ? self::$WithdrawChannelName[$value] : '';
    }

    public function getAwardListAttribute()
    {
        return is_array($this->attributes['WithdrawInfo']) ? $this->attributes['WithdrawInfo'] : json_decode($this->attributes['WithdrawInfo'],true);
    }

    public function remark()
    {
        return $this->hasOne('App\Models\WithdrawRemarkModel', 'pid','WithdrawId');
    }

}
