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


use Illuminate\Database\Eloquent\Model;

class SysNoticeModel extends Model
{
    protected $table = 'sys_notice';

    /**
     * 自动 写入
     * @var array
     */
    protected $fillable = ['info', 'interval', 'is_circul', 'play_start_time', 'play_end_time'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 循环
     * @var array
     */
    public static $is_loop = [
        1 => '是',
        0 => '否'
    ];

    /**
     * 取得中文名
     * @param $value
     * @return mixed|string
     */
    public function getIsCirculAttribute($value)
    {
        return isset(self::$is_loop[$value]) ? self::$is_loop[$value] : '';
    }


}