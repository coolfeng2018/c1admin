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
 * 消息
 * Class TmpMessageModel
 * @package App\Models
 */
class TmpMessageModel extends BaseModel
{
    protected $table      = 'message';
    protected $connection = 'mysql_one_by_one';
    protected $customer_id = 888888;
    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['MessageId','FromUid','ToUid','read_state','message','reback','time'];

    /**
     * 追加非表中属性
     * @var array
     */
    protected $appends = ['read_state_str','reback_str','FromUidStr','ToUidStr'];
    /**
     * 回复类型
     * @var array
     */
    public static $reBackArr = [
        0 => '未回复',
        1 => '已回复',
    ];

    /**
     * 读类型
     * @var array
     */
    public static $readStateArr = [
        0 => '未读',
        1 => '已读',
    ];

    /**
     * 取得回复类型中文名
     * @return mixed|string
     */
    public function getReBackStrAttribute()
    {
        $value = isset($this->attributes['reback']) ? $this->attributes['reback'] : 0 ;
        return isset(self::$reBackArr[$value]) ? self::$reBackArr[$value] : '';
    }


    /**
     * 取得读类型中文名
     * @return mixed|string
     */
    public function getReadStateStrAttribute()
    {
        $value = isset($this->attributes['read_state']) ? $this->attributes['read_state'] : 0 ;
        return isset(self::$readStateArr[$value]) ? self::$readStateArr[$value] : '';
    }

    /**
     * 取得读类型中文名
     * @return mixed|string
     */
    public function getFromUidStrAttribute()
    {
        $value = isset($this->attributes['FromUid']) && $this->attributes['FromUid'] == $this->customer_id ? "客服": "玩家" ;
        return $value;
    }

    /**
     * 取得读类型中文名
     * @return mixed|string
     */
    public function getToUidStrAttribute()
    {
        $value = isset($this->attributes['ToUid']) && $this->attributes['ToUid'] == $this->customer_id ? "客服": "玩家" ;
        return $value;
    }
}