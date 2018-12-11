<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/20 10:29
 * +------------------------------
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

/**
 * 单表配置 - TODO:针对服务端单条配置都放置在此模型
 * Class SysConfigModel
 * @package App\Models
 */
class SysConfigModel extends Model
{
    protected $table = 'sys_config';

    /**
     * 允许写入字段
     * @var array
     */
    protected $fillable = ['sys_key', 'sys_val'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 排行榜配置
     */
    const RANK_CONTROL_KEY = 'rank_control.lua';

    /**
     * 百人牛牛机器人控制配置
     */
    const ROBOT_BANKER_CONTROL_KEY = 'robot_banker_control.lua';

    /**
     * 百人牛牛十倍场机器人控制配置
     */
    const ROBOT_TEN_BANKER_CONTROL_KEY = 'robot_ten_banker_control.lua';


    /**
     * 百人牛牛系统庄家配置
     */
    const BRNN_BANKER_KEY = 'brnn_banker.lua';


    /**
     * 用户触发配置
     */
    const USER_TRIGGER_KEY = 'user_guide_trigger.lua';

    /**
     * 用户引导配置
     */
    const USER_GUIDE_KEY = 'user_guide.lua';

    /**
     * 百人场配置
     */
    const HUNDRED_CONFIG_KEY = 'hundred_config.lua';

    /**
     * 百人场最低投注配置
     */
    const HUNDRED_MIN_BET_CONFIG_KEY = 'hundred_min_bet_config.lua';

    /**
     * 新人奖励
     */
    const NEWBIE_AWARD_CONFIG_KEY = 'newbie_award.lua';

    /**
     * 扑鱼库存控制
     */
    const FISHING_STORE_KEY = 'fishing_store.lua';


    /**
     * 扑鱼修正配置控制
     */
    const FISHING_CORRECTION_KEY = 'fishing_correction.lua';

    /**
     * 扑鱼修正配置控制
     */
    const FISHING_POWERRATE_KEY = 'fishing_powerrate.lua';

    /**
     * 牛牛库存
     */
    const STORE_NN_KEY = 'store_nn_key.lua';

    /**
     * 扎金花库存
     */
    const STORE_ZJH_KEY = 'store_zjh_key.lua';

    /**
     * 百人牛牛-库存
     */
    const STORE_BRNN_KEY = 'store_brnn_key.lua';

    /**
     * 黑红大战-库存
     */
    const STORE_HHDZ_KEY = 'store_hhdz_key.lua';

    /**
     * 财神驾到-库存
     */
    const STORE_MAMMON_KEY = 'caishenjiadao_store.lua';

    /**
     * 财神驾到-游戏配置
     */
    const HALL_MAMMON_KEY = 'caishenjiadao.lua';

    /**
     * 欢乐足球-库存
     */
    const STORE_LFDJ_KEY = 'store_lfdj_key.lua';

    /**
     * 水果机-库存
     */
    const STORE_FRUIT_KEY = 'fruit_store.lua';


    /**
     * 捕鱼-个人命中系数控制配置
     */
    const FISH_PLAYER_RATE_CONFIG_KEY = 'fish_player_rate_config.lua';

    /**
     * 举报功能配置
     */
    const COMPLAINT_CONFIG_KEY = 'complaint_config.lua';

    /**
     * 注册限制
     */
    const REGISTRAT_LIMIT_KEY = 'registrat_limit_config';

    /**
     * vip 微信列表配置
     */
    const RECHARGE_CONFIG_KEY = 'recharge_config';

    /**
     * 微信客服列表配置
     */
    const WECHAT_SERVICE_CONFIG_KEY = 'wechat_service_config';

    /**
     * 水果机配置
     */
    const FRUIT_TIGER_RATE_KEY = 'tiger_rate.lua';


    /**
     * 周福利返利配置
     */
    const WEEK_REWARD_KEY = 'seven_raward.lua';

    /**
     * 扑鱼VIP炮台配置
     */
    const FISHING_GUNS_KEY = 'fishing_guns.lua';


    /**
     * GM相关配置
     */
    const PERSONAL_CONTROL_KEY = 'personal_control.lua';

    /**
     *
     */
    const ROBOT_RANK_VIP_KEY = 'robot_rank_vip.lua';

    /**
     * 大抽奖库存配置
     */
    const AWARD_ONE = 'award_one.lua';

    /**
     * 大抽奖玩法配置
     */
    const AWARD_TWO = 'award_two.lua';

    /**
     * 大抽奖综合配置
     */
    const AWARD = 'award.lua';

    /**
     * 排行榜字段列表 TODO:根据服务端字段+表单类型写入，在模板中遍历渲染
     */
    const RANK_CONTROL_FIELD = [
        ['name' => 'show', 'title' => '排行榜显示配置', 'type' => 'checkbox', 'help' => '排行榜显示设置', 'option' => [1 => '今日赚金排行', 2 => '今日提现排行', 3 => '在线时长排行']],
        ['name' => 'coins', 'title' => '金币上榜条件', 'type' => 'number', 'help' => '金币上榜条件（元）', 'option' => ['min' => 0]],
        ['name' => 'fech', 'title' => '提现上榜条件', 'type' => 'number', 'help' => '提现上榜条件（元）', 'option' => ['min' => 0]],
        ['name' => 'time', 'title' => '在线时长', 'type' => 'number', 'help' => '在线时长 上榜条件(秒)', 'option' => ['min' => 0]],
        ['name' => 'refresh_time', 'title' => '刷新时间', 'type' => 'number', 'help' => '刷新时间(分)', 'option' => ['min' => 0]],
        ['name' => 'robot_change_rate', 'title' => '机器人数值改变概率', 'type' => 'number', 'help' => '机器人数值改变概率(0 - 100数字)', 'option' => ['min' => 0, 'max' => 100]],
        ['name' => 'robot_change', 'title' => '机器人数值改变范围倍数（小）', 'type' => 'number', 'help' => '机器人数值改变范围倍数{0,10000}', 'flag' => 'and', 'option' => ['min' => 0, 'max' => 10000]],
    ];

    const ROBOT_BANKER_CONTROL_FIELD = [
//        'brnn_normal' => ['name' => 'brnn_normal', 'title' => '百人牛牛机器人控制配置', 'type' => 'string','help' => '百人牛牛机器人控制设置'],
        [
            'name' => 'banker_rate',
            'title' => '牌局中的人数对应的概率和上庄人数',
            'type' => 'number',
            'help' => '牌局中的人数对应的概率和上庄人数设置',
            'option' => [
                '人数范围:' => ['min' => 0, 'max' => 555555555, 'type' => 'number', 'name' => 'people'],
                '概率值:' => ['min' => 0, 'type' => 'number', 'name' => 'rate'],
                '上庄人数:' => ['min' => 0, 'type' => 'number', 'name' => 'people_num'],
            ]
        ],
        [
            'name' => 'banker_round',
            'title' => '上庄机器人带的金币所对应的上庄局数',
            'type' => 'number',
            'help' => '上庄机器人带的金币所对应的上庄局数设置',
            'option' => [
                '金币范围:' => ['min' => 0, 'max' => 90000, 'type' => 'number', 'name' => 'coin'],
                '上庄局数:' => ['min' => 0, 'max' => 100, 'flag' => 'and', 'type' => 'number', 'name' => 'round_range'],
            ]
        ],
        ['name' => 'banker_interval', 'title' => '上庄间隔:', 'type' => 'number', 'help' => '机器人上庄间隔设置', 'option' => ['min' => 0]],
        ['name' => 'banker_cancel', 'title' => '取消概率:', 'type' => 'number', 'help' => '玩家上庄前面有机器人取消概率设置', 'option' => ['min' => 0]],
    ];

    /**
     * 设置属性
     * @param $val
     * @return false|string
     */
    public function setSysValAttribute($val)
    {
        $this->attributes['sys_val'] = json_encode($val);
    }

    /**
     *
     * @param $value
     * @return mixed
     */
    public function getSysValAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * 取得sys_val配置
     * @param $key
     * @return mixed
     */
    public static function getSysVal($key)
    {
        return self::where(['sys_key' => $key])->value('sys_val');
    }

    /**
     * 根据key 取得配置数组
     * @param $key
     * @return string
     */
    public static function getSysKeyExists($key)
    {
        $rank_count = self::where(['sys_key' => $key])->count();
        $config = [];
        if ($rank_count > 0) {
//            $config = self::where(['sys_key' => $key])->first();
            $config = self::getSysVal($key);
        }

        return $config;
    }

    /**
     * 更新数据
     * @param $key
     * @param $data
     * @return bool
     */
    public static function saveSysVal($key, $data)
    {
        if (isset($data['_token'])) unset($data['_token']);
        if (isset($data['_url'])) unset($data['_url']);

        if (self::where(['sys_key' => $key])->count() > 0) {
            //更新
            if (self::where(['sys_key' => $key])->update(['sys_val' => json_encode($data)])) {
                return true;
            }
        } else {
            //添加
            if (self::create(['sys_key' => $key, 'sys_val' => $data])) {
                return true;
            }
        }
        return false;
    }

    /**
     * 获取多个配置数据
     * @param array $keyArr
     * @return array
     */
    public static function getManySysKeyExists($keyArr=[]){
        if (empty($keyArr))
            return [];
        return self::whereIn('sys_key',$keyArr)->select('sys_val')->get()->toArray();
    }
}

