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


use Illuminate\Database\Eloquent\Model;

/**
 * 排行榜数据统计
 * Class DataRankBoard
 * @package App\Models
 */
class DataRankBoard extends Model
{
    protected $table = 'data_rank_board';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['type', 'nick_name', 'uid', 'today_income', 'rank_level', 'recharge_money', 'charge_money', 'online_time'];

    /**
     * 排行类型
     * @var array
     */
    public static $type = [
        1 => '赚金排行',
        2 => '兑换排行',
        3 => '在线排行'
    ];


    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';


}