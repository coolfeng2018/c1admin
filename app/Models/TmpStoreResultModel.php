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
 * 临时 库存流水日志 老后台表  （老后台表  暂时不能完全迁移过来的表）
 * Class DataRankBoard
 * @package App\Models
 */
class TmpStoreResultModel extends BaseModel
{
    protected $connection = 'mysql_data_center';

    protected $table      = 'store_result';

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = false;

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['today','modified_time','fee_store','award_store','robot_type','base_store'];

    /**
     * 追加非表中属性
     * @var array
     */
    protected $appends = ['robot_type_str'];

    /**
     * robot_type
     * @return mixed|string
     */
    public function getRobotTypeStrAttribute()
    {
        $value = isset($this->attributes['robot_type']) ? $this->attributes['robot_type'] : '' ;
        $robotTypes = config('game.robot_type_list');
        return isset($robotTypes[$value]) ? $robotTypes[$value] : '';
    }
}