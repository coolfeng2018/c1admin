<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: frans
 * +------------------------------
 * DateTime: 2018/9/17 19:27
 * +------------------------------
 */

/**
 *  统一设置缓存 KEY
 *  获取方法：config('cacheKey.key')
 */
return [
    'REDIS_HASH_PAY_LIST' => 'hash:bills', // 充值 待处理集合
    'REDIS_PAY_ORDER_QUEUE' => 'orderPayment', // 充值成功订单队列
    'REDIS_PAY_UNION_ORDER' => 'pay:union_order', //银行卡转账订单号生成标志
    'REDIS_ORDER_KEY'  => 'publicorder_',    //订单
    'SERVER_GAME_LIST' => 'server_game_list', //服务端有些列表
    'REDIS_CUSTOMER_FLAG' => 'hash:customer', //客服未回复标志
];
