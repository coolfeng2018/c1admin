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
 * 用户头像信息
 * Class DataRankBoard
 * @package App\Models
 */
class DataTableOacModel extends BaseModel
{
    protected $table = 'data_table_oac';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['date','reason','table_money'];


    /**
     * 追加非表中属性
     * @var array
     */
//    protected $appends = ['game_type_str','table_type_str'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;


    /**
     * game_type
     * @return mixed|string
     */
    public function getGameTypeStrAttribute()
    {
        $value = isset($this->attributes['game_type']) ? $this->attributes['game_type'] : '' ;
        $gameTypes = config('game.game_list');
        return isset($gameTypes[$value]) ? $gameTypes[$value] : '';
    }

    /**
     * table_type
     * @return mixed|string
     */
    public function getTableTypeStrAttribute()
    {
        $value = isset($this->attributes['table_type']) ? $this->attributes['table_type'] : '' ;
        $tableTypes = config('game.table_list');
        return isset($tableTypes[$value]) ? $tableTypes[$value] : '';
    }
}