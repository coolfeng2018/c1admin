<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 11:14
 * +------------------------------
 */

namespace App\Models;

/**
 * 大厅列表
 * Class SysGameListModel
 * @package App\Models
 */
class SysGameListModel extends BaseModel
{
    protected $table = 'sys_game_list';

    /**
     * 自动 写入
     * @var array
     */
    protected $fillable = ['game_type', 'position', 'shown_type', 'notice_type', 'status', 'guide_status', 'created_at', 'updated_at'];

    //追加非表中属性
    protected $appends = ['guide_status_str'];
    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 大厅进入类型
     * @var array
     */
    public static $shownType = [
        1 => "普通金币房",
        2 => "私人房",
        3 => "快速进入房",
    ];

    /**
     * 角标
     * @var array
     */
    public static $noticeType = [
        0 => "无",
        1 => "推荐",
        2 => "热门",
    ];

    /**
     * 大厅游戏状态
     * @var array
     */
    public static $status = [
        0 => "正常",
        1 => "敬请期待",
    ];

    public static $guideStatusStr = [
        1 => "是",
        2 => "否"
    ];

    public function getGuideStatusStrAttribute()
    {
        $value = isset($this->attributes['guide_status']) ? $this->attributes['guide_status'] : '' ;
        return isset(self::$guideStatusStr[$value]) ? self::$guideStatusStr[$value] : '';
    }

    /**
     * 获取游戏中文名
     * @param $val
     * @return mixed
     */
    public function getGameTypeAttribute($val)
    {
        return isset(config('game.game_list')[$val]) ? config('game.game_list')[$val] : $val;
    }

    /**
     * 获取角标中文名
     * @param $val
     * @return mixed
     */
    public function getNoticeTypeAttribute($val)
    {
        return isset(self::$noticeType[$val]) ? self::$noticeType[$val] : $val;
    }

    /**
     * 获取类型中文名
     * @param $val
     * @return mixed
     */
    public function getShownTypeAttribute($val)
    {
        return isset(self::$shownType[$val]) ? self::$shownType[$val] : $val;
    }

    /**
     * 获取状态中文名
     * @param $val
     * @return mixed
     */
    public function getStatusAttribute($val)
    {
        return isset(self::$status[$val]) ? self::$status[$val] : $val;
    }

}