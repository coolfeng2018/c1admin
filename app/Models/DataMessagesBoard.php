<?php

namespace App\Models;

/**
 * 留言板
 */
class DataMessagesBoard extends BaseModel
{
    protected $table      = 'data_messages_board';

    protected $fillable = ['name', 'phone', 'content', 'status', 'remarks', 'created_at'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;
    /**
     * 追加非表中属性
     * @var array
     */
    protected $appends = ['status_name'];
    /**
     * 状态类型
     * @var array
     */
    public static $statusArr = [
        1 => '未处理',
        2 => '已处理'
    ];


    /**
     * 取得状态中文名
     * @return string
     */
    public function getStatusNameAttribute()
    {
        $value = isset($this->attributes['status']) ? $this->attributes['status'] : '' ;
        return isset(self::$statusArr[$value]) ? self::$statusArr[$value] : '';
    }

}
