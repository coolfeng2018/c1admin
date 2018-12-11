<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/10/22 10:08
 * +------------------------------
 */

/**
 * eg: 运行此命令批量发送配置至服务器 php artisan command:publish_config
 * // 待发送配置选项 类名称=>发送方法名称( 默认 send,多个用,隔开)
 *  \App\Http\Controllers\Admin\BrnnController::class=>'send',
 */
return [
    
    //待发送配置选项 类名称=>发送方法名称

    \App\Http\Controllers\Admin\HundredController::class=>'send',
    \App\Http\Controllers\Admin\FishCorrectionController::class=>'send',
    \App\Http\Controllers\Admin\FishPowerrateController::class=>'send',

    \App\Http\Controllers\Admin\BrnnController::class=>'send',
    \App\Http\Controllers\Admin\BrnnTenController::class=>'send',
    \App\Http\Controllers\Admin\GunsController::class=>'send',
    \App\Http\Controllers\Admin\FishPlayerController::class=>'send',
    \App\Http\Controllers\Admin\GameConfig\BrnnBankerController::class=>'send',

    \App\Http\Controllers\Admin\VipController::class=>'send',
    \App\Http\Controllers\Admin\AvatarController::class=>'send',
    \App\Http\Controllers\Admin\RobotController::class=>'send,sendRank',

    \App\Http\Controllers\Admin\GameListController::class=>'send',
    \App\Http\Controllers\Admin\RankController::class=>'send',
    \App\Http\Controllers\Admin\BroadcastController::class=>'send',
    \App\Http\Controllers\Admin\NoticeController::class=>'send',

    \App\Http\Controllers\Admin\LeadController::class=>'sendUserGuideConfig,sendUserTriggerConfig,sendPersonalConfig',

    \App\Http\Controllers\Admin\Store\FishStoreController::class=>'send',

    \App\Http\Controllers\Admin\Store\CattleStoreController::class=>'send',
//    \App\Http\Controllers\Admin\Store\ZjhStoreController::class=>'send',
//    \App\Http\Controllers\Admin\Store\BrnnStoreController::class=>'send',
//    \App\Http\Controllers\Admin\Store\HhdzStoreController::class=>'send',
//    \App\Http\Controllers\Admin\Store\LfdjStoreController::class=>'send',

    \App\Http\Controllers\Admin\Store\MammonStoreController::class=>'send,playSend',

    \App\Http\Controllers\Admin\Store\FruitsStoreController::class=>'send',

    \App\Http\Controllers\Admin\Store\GranddrawController::class=>'send',

    \App\Http\Controllers\Admin\Hall\WeekRewardController::class=>'send',
    \App\Http\Controllers\Admin\Hall\FruitController::class=>'send',
    \App\Http\Controllers\Admin\ActivityListController::class=>'send',
];
