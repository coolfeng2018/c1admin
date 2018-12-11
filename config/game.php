<?php

return [

    /*
    |--------------------------------------------------------------------------
    | game 全局游戏相关配置
    |--------------------------------------------------------------------------
    |
    */
    /*机器人类型*/
    'robot_type_list'=>[

        'zjh_junior'=>'扎金花初级场 ',
        'zjh_normal'=>' 扎金花普通场 ',
        'zjh_three'=>'扎金花精英场 ',
        'zjh_four'=>'扎金花土豪场 ',

        'nn_normal'=>'看牌抢庄新手场 ',
        'nn_senior'=>'看牌抢庄精英场 ',
        'nn_three'=>'看牌抢庄大师场 ',
        'nn_four'=>' 看牌抢庄土豪场 ',

        'ddz_junior'=>'斗地主新手场 ',
        'ddz_normal'=>'斗地主普通场 ',

        'hhdz_normal'=>'红黑大战普通场 ',
        'brnn_normal'=>'百人牛牛普通场 ',
        'lfdj_normal'=>'欢乐足球普通场 ',

        'bj_junior' => '21点初级',
        'bj_normal' => '21点普通场',
        'bj_senior' => '21点大师场',

        'fishing_junior' => '扑鱼初级场',
        'fishing_normal' => '扑鱼中级场',
        'fishing_senior' => '扑鱼高级场',


    ],

    /*游戏 类型*/
    'game_list'=>[
        1=>'扎金花',
        2=>'看牌抢庄',
        3=>'斗地主',
        200000=>'红黑大战',
        200001=>'百人牛牛',
        200002=>'欢乐足球',
        6     =>'捕鱼',
        200003     =>'水果机',
    ],

    /* 游戏金币*/
    'goods' => [
        110 => ['productName' => '金币100'],
        111 => ['productName' => '金币290'],
        112 => ['productName' => '金币490'],
        113 => ['productName' => '金币990'],
        114 => ['productName' => '金币1690'],
        115 => ['productName' => '金币3990'],
        116 => ['productName' => '金币6990'],
        117 => ['productName' => '金币19990'],
    ],


    /*桌子 房间类型*/
    'table_list'=>[
        0   => '大厅',
        100 => '金花初级',
        101 => '金花普通',
        102 => '金花精英',
        103 => '金花土豪',
        200 => '牛牛新手',
        201 => '牛牛精英',
        202 => '牛牛大师',
        203 => '牛牛土豪',
        200001 => '百人牛牛-3倍场',
        200000 => '红黑',
        200002 => '欢乐足球',
        200003 => '水果机',
        200004 => '百人牛牛-10倍场',
        300 => '斗地主初级',
        301 => '斗地主中级',
        302 => '斗地主高级',
        500 => '21点初级',
        501 => '21点普通场',
        502 => '21点大师场',
        503 => '21点土豪场',
        600 => '扑鱼初级场',
        601 => '扑鱼中级场',
        602 => '扑鱼高级场'
    ],

    /* 金币变化原因 类型*/
    'gold_reason_list'=>[
        1=>['en'=>'BET_COIN','cn'=>'押注'],
        2=>['en'=>'WIN_COIN','cn'=>'赢金币'],//+
        3=>['en'=>'BET_COIN_BACK','cn'=>'押注失败金币返回'],
        4=>['en'=>'COST_COIN_ERROR_BACK','cn'=>'扣除金币失败返还'],
        6=>['en'=>'PAY_FEE','cn'=>'扣台费'],
        7=>['en'=>'USE_MAGIC_PICTRUE','cn'=>'使用魔法表情'],
        15=>['en'=>'PAY_COMMISSION','cn'=>'抽取佣金-红黑大战抽取台费'],
        16=>['en'=>'FISHING_FIRE','cn'=>'捕鱼-捕鱼开火'],
        17=>['en'=>'FISHING_CATCH','cn'=>'捕鱼-捕中鱼'],
        18=>['en'=>'FISHING_BUY_BACK','cn'=>'捕鱼-购买失败金币返回'],
        19=>['en'=>'FISHING_BUY_ITEM','cn'=>'捕鱼-购买道具'],
        20=>['en'=>'FISHING_BACK_COINS','cn'=>'捕鱼-子弹退还'],
        100000=>['en'=>'GAMECOIN_BANKRUPT','cn'=>'破产补助'],
        100001=>['en'=>'GAMECOIN_REGISTER','cn'=>'注册送金币'],
        100002=>['en'=>'GAMECOIN_SYS_ADD','cn'=>'后台加金币'],
        100003=>['en'=>'GAMECOIN_SYS_MINUS','cn'=>'后台减金币'],
        100004=>['en'=>'GAMECOIN_SHARE','cn'=>'分享奖励'],
        100005=>['en'=>'GAMECOIN_BIND','cn'=>'绑定奖励'],
        100006=>['en'=>'GAMECOIN_PROMOTION_LST','cn'=>'活动推广金币消耗'],
        100007=>['en'=>'GAMECOIN_PROMOTION_WIN','cn'=>'活动推广金币奖励'],
        100008=>['en'=>'GAMECOIN_CHARGE_REWARD','cn'=>'首充送金币'],
        100019=>['en'=>'SIGN_IN','cn'=>'签到'],
        100020=>['en'=>'TAKE_SIGN_AWARD','cn'=>'领取签到奖励'],
        100021=>['en'=>'TAKE_TASK_AWARD','cn'=>'领取任务奖励'],
        100022=>['en'=>'TAKE_MAIL_ATTACH','cn'=>'领取邮件奖励'],
        100023=>['en'=>'GM','cn'=>'GM操作'],
        100025=>['en'=>'BUY_FROM_SHOP','cn'=>'商城购买'],
        100027=>['en'=>'NEWBIE_AWARD','cn'=>'新手奖励'],
        100028=>['en'=>'COST_COIN_ERROR_BACK','cn'=>'充值'],
        100029=>['en'=>'COST_COIN_ERROR_BACK','cn'=>'为机器人增加金币'],
        100030=>['en'=>'ADD_COINS_FOR_ROBOT','cn'=>'领取任务奖励'],

        100040=>['en'=>'EXCHANGE_COINS','cn'=>'兑换金币'],
        100041=>['en'=>'BIND_PHONE_REWARD','cn'=>'绑定手机奖励'],
        100039=>['en'=>'DESPOSIT_SAFE_BOX','cn'=>'保险箱操作'],
        100049=>['en'=>'SEVEN_AWARD_EXCHANGE','cn'=>'周福利兑换'],
        100050=>['en'=>'NEW_BIND_LUCKY_DRWA','cn'=>'拉新活动抽奖'],
        100051=>['en'=>'','cn'=>'财神驾到'],
        100052=>['en'=>'','cn'=>'大抽奖'],
    ],


    //水果机种类
    'fruit_list'=>[
        1 => '橘子',
        2 => '西瓜',
        3 => '柠檬',
        4 => '葡萄',
        5 => '猕猴桃',
        6 => '铃铛',
        7 => '樱桃',
        8 => '钻石',
        9 => 'bonus',
        10=> '777'
    ],


    /*产出与消耗类型*/
    'oac_list'=>[
        100001 => '注册送金币',//产出
        100028 => '充值',//产出
        100049 => '周福利兑换',//产出
        100040 => '兑换金币',//消耗
        6 => '扣台费',//消耗
        15 => '抽取佣金-红黑大战抽取台费',//消耗
        'pay_fee' => '台费',//=> 6 + 15 //消耗
        'stock_totle' => '库存收入',//消耗 库存收入 => 当天库存数据统计值
        'gold_surplus' => '金币存量',//金币存量 => (注册赠送+周福利兑换+充值)-(台费+库存收入+兑换)
    ],
];