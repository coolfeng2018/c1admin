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
class DataUserHeadModel extends BaseModel
{
    protected $table = 'data_user_head';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['uid','head_url','o_desc', 'o_status', 'op_name', 'updated_at'];

    /**
     * 追加非表中属性
     * @var array
     */
    protected $appends = ['o_status_str','head_url_str'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 状态类型
     * @var array
     */
    public static $oStatusArr = [
        0 => '审核中',
        1 => '已拒绝',
        2 => '已通过',
    ];

    /**
     * 取得状态类型中文名
     * @return mixed|string
     */
    public function getOStatusStrAttribute()
    {
        $value = isset($this->attributes['o_status']) ? $this->attributes['o_status'] : '' ;
        return isset(self::$oStatusArr[$value]) ? self::$oStatusArr[$value] : '';
    }
    /**
     * 取得状态类型中文名
     * @return mixed|string
     */
    public function getHeadUrlStrAttribute()
    {
        $headUrlStr = config('server.file_upload_upload_url').'/'.$this->attributes['head_url'] ;
        return $headUrlStr;
    }
}