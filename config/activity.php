<?php

return [

    /*
    |--------------------------------------------------------------------------
    | activity 全局 活动 相关配置
    |--------------------------------------------------------------------------
    |
    */
    /*活动类型*/
    'activity_type_list'=>[
        1=>'拉新活动',
    ],

    /*拉新活动配置*/
    'type_1'=>[
        'card_rate'=>[
            // 牌 概率 奖励积分 奖励金币
            1=>['card'=>'A','rate'=>2,'award_score'=>10,'award_coins'=>5000],
            2=>['card'=>'2','rate'=>8,'award_score'=>5,'award_coins'=>0],
            3=>['card'=>'3','rate'=>8,'award_score'=>5,'award_coins'=>0],
            4=>['card'=>'4','rate'=>8,'award_score'=>5,'award_coins'=>0],
            5=>['card'=>'5','rate'=>8,'award_score'=>5,'award_coins'=>0],
            6=>['card'=>'6','rate'=>8,'award_score'=>5,'award_coins'=>0],
            7=>['card'=>'7','rate'=>8,'award_score'=>5,'award_coins'=>0],
            8=>['card'=>'8','rate'=>8,'award_score'=>5,'award_coins'=>0],
            9=>['card'=>'9','rate'=>8,'award_score'=>5,'award_coins'=>0],
            10=>['card'=>'10','rate'=>18,'award_score'=>10,'award_coins'=>1000],
            11=>['card'=>'J','rate'=>5,'award_score'=>10,'award_coins'=>2000],
            12=>['card'=>'Q','rate'=>5,'award_score'=>10,'award_coins'=>3000],
            13=>['card'=>'K','rate'=>3,'award_score'=>10,'award_coins'=>4000],
            14=>['card'=>'小王','rate'=>1,'award_score'=>10,'award_coins'=>8000],
            15=>['card'=>'大王','rate'=>1,'award_score'=>10,'award_coins'=>10000],
        ]
    ]
];
