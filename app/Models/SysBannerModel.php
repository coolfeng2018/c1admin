<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/25 10:44
 * +------------------------------
 */

namespace App\Models;

/**
 * 游戏大厅轮播图
 * Class SysBannerModel
 * @package App\Models
 */
class SysBannerModel extends BaseModel
{

    protected $table = 'sys_banner' ;

    protected $fillable = ['channel', 'channel_key', 'pic_one' ,'pic_one_type', 'pic_one_url', 'pic_two', 'pic_two_type', 'pic_two_url',  'pic_three', 'pic_three_type', 'pic_three_url', 'created_at', 'updated_at'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = true;
    //#此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';

    //追加非表中属性
    protected $appends = ['pic_one_img', 'pic_two_img', 'pic_three_img'];

    /**
     * 图片选择类型
     * @var array
     */
    public static $method = [
        1 => '普通',
        2 => '复制',
        3 => '跳转网页',
        4 => '跳转'
    ];

    /**
     * 图片跳转类型
     * @var array
     */
    public static $JumpName = [
        1001 => '大抽奖',
        1002 => 'VIP',
        1003 => '广招代理',
        1004 => '周福利',
        1005 => '客服',
        1006 => '兑换',
        1007 => '充值',
    ];

    /**
     * 地址1
     * @param $value
     * @return mixed|string
     */
    public function getPicOneImgAttribute()
    {
        $value = isset($this->attributes['pic_one']) ? $this->attributes['pic_one'] : '' ;
        $key = config('server.file_upload_upload_url');
        if(strpos($value,$key) === false ){
            $value = $key .'/'. $value;
        }
        return $value;
    }

    /**
     * 地址2
     * @param $value
     * @return mixed|string
     */
    public function getPicTwoImgAttribute()
    {
        $value = isset($this->attributes['pic_two']) ? $this->attributes['pic_two'] : '' ;
        $key = config('server.file_upload_upload_url');
        if(strpos($value,$key) === false ){
            $value = $key .'/'. $value;
        }
        return $value ;
    }

    /**
     * 地址3
     * @param $value
     * @return mixed|string
     */
    public function getPicThreeImgAttribute()
    {
        $value = isset($this->attributes['pic_three']) ? $this->attributes['pic_three'] : '' ;
        $key = config('server.file_upload_upload_url');
        if(strpos($value,$key) === false ){
            $value = $key .'/'. $value;
        }
        return $value;
    }
}