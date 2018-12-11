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
 * 渠道管理临时表
 * Class OrderModel
 * @package App\Models
 */
class TmpChannelListModel extends Model
{
    protected $table      = 'channel_list';
    protected $connection = 'mysql_one_by_one';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['name','code','created_time','modified_time','status','uid'];

    public $timestamps = false;
    /**
     * updated_at 时间格式化
     * @param $value
     */
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = is_numeric($value) ? $value : strtotime($value);
    }

    /**
     * updated_at 时间格式化
     * @return false|string
     */
    public function getUpdatedAtAttribute($value)
    {
        return is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value ;
    }

    /**
     * modified_time 时间格式化
     * @param $value
     */
    public function setModifiedTimeAttribute($value)
    {
        $this->attributes['modified_time'] = is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value;
    }

    /**
     * created_time 时间格式化
     * @param $value
     */
    public function setCreatedTimeAttribute($value)
    {
        $this->attributes['created_time'] = is_numeric($value) ? date('Y-m-d H:i:s', $value) : $value;
    }


    /**
     * 获取渠道列表
     * @return array
     */
    public function getChannel() {
        $result = $this->select('code')->get();
        $channel = [];
        foreach ($result as $val) {
            $channel[] = $val->code;
        }
        return $channel;
    }


}