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
 * 用户数据获取
 * Class OrderModel
 * @package App\Models
 */
class TmpPlatformMailModel extends BaseModel
{
    protected $table      = 'platform_mail';
    protected $connection = 'mysql_one_by_one';

    public static $MAIL_STATUS_TOBE = 0;//待发送
    public static $MAIL_STATUS_ISTOBE = 1;//已发送
    public static $MAIL_STATUS_DELETE = 2;//已删除（不是已领取状态,可以修改邮件，修改后重置为状态为待发送,重置未读/已读）

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['title','content','mail_type','range','attach_list','status','read_state','receive_state','op_user','coins','coins','create_at'];

    protected $appends = ['status_name'];

    public $timestamps = false;


    protected $status = [
        1 => '已读',
        2 => '未读',
        3 => '已经领取',
        4 => '未领取',
        5 => '待发送',
    ];

    public function getStatusNameAttribute($value)
    {
        if(isset($this->status[$this->attributes['status']])){
            return $this->read_state?($this->coins?($this->receive_state?$this->status[3]:$this->status[4]):$this->status[1]):$this->status[2];
        }else{
            return $this->status[5];
        }
    }
}