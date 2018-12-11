<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台公共路由部分
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['operatelog']], function () {
    //登录、注销
    Route::get('login', 'LoginController@showLoginForm')->name('admin.loginForm');
    Route::post('login', 'LoginController@login')->name('admin.login');
    Route::get('logout', 'LoginController@logout')->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台需要授权的路由 admins
|
*/
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog']], function () {
    //后台布局
    Route::get('/', 'IndexController@layout')->name('admin.layout');
    //后台首页
    Route::get('/index', 'IndexController@index')->name('admin.index');
    Route::get('/index1', 'IndexController@index1')->name('admin.index1');
    Route::get('/index2', 'IndexController@index2')->name('admin.index2');
    //图标
    Route::get('icons', 'IndexController@icons')->name('admin.icons');
    Route::get('btnsearch', 'IndexController@btnSearch')->name('admin.btnsearch');
});

//系统管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:system.manage']], function () {
    //数据表格接口
    Route::get('data', 'IndexController@data')->name('admin.data')->middleware('permission:system.role|system.user|system.permission');

    //操作日志
    Route::group(['middleware' => ['permission:system.opreatelog']], function () {
        Route::get('opreatelog', 'IndexController@opreateLog')->name('admin.opreatelog');
        Route::get('opreatelog/data', 'IndexController@opreateData')->name('admin.opreatelog.data');
    });

    //用户管理
    Route::group(['middleware' => ['permission:system.user']], function () {
        Route::get('user', 'UserController@index')->name('admin.user');
        //添加
        Route::get('user/create', 'UserController@create')->name('admin.user.create')->middleware('permission:system.user.create');
        Route::post('user/store', 'UserController@store')->name('admin.user.store')->middleware('permission:system.user.create');
        //编辑
        Route::get('user/{id}/edit', 'UserController@edit')->name('admin.user.edit')->middleware('permission:system.user.edit');
        Route::put('user/{id}/update', 'UserController@update')->name('admin.user.update')->middleware('permission:system.user.edit');
        //删除
        Route::delete('user/destroy', 'UserController@destroy')->name('admin.user.destroy')->middleware('permission:system.user.destroy');
        //分配角色
        Route::get('user/{id}/role', 'UserController@role')->name('admin.user.role')->middleware('permission:system.user.role');
        Route::put('user/{id}/assignRole', 'UserController@assignRole')->name('admin.user.assignRole')->middleware('permission:system.user.role');
        //分配权限
        Route::get('user/{id}/permission', 'UserController@permission')->name('admin.user.permission')->middleware('permission:system.user.permission');
        Route::put('user/{id}/assignPermission', 'UserController@assignPermission')->name('admin.user.assignPermission')->middleware('permission:system.user.permission');
    });
    //角色管理
    Route::group(['middleware' => 'permission:system.role'], function () {
        Route::get('role', 'RoleController@index')->name('admin.role');
        //添加
        Route::get('role/create', 'RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
        Route::post('role/store', 'RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
        //编辑
        Route::get('role/{id}/edit', 'RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
        Route::put('role/{id}/update', 'RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
        //删除
        Route::delete('role/destroy', 'RoleController@destroy')->name('admin.role.destroy')->middleware('permission:system.role.destroy');
        //分配权限
        Route::get('role/{id}/permission', 'RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
        Route::put('role/{id}/assignPermission', 'RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
    });
    //权限管理
    Route::group(['middleware' => 'permission:system.permission'], function () {
        Route::get('permission', 'PermissionController@index')->name('admin.permission');
        //添加
        Route::get('permission/create', 'PermissionController@create')->name('admin.permission.create')->middleware('permission:system.permission.create');
        Route::post('permission/store', 'PermissionController@store')->name('admin.permission.store')->middleware('permission:system.permission.create');
        //编辑
        Route::get('permission/{id}/edit', 'PermissionController@edit')->name('admin.permission.edit')->middleware('permission:system.permission.edit');
        Route::put('permission/{id}/update', 'PermissionController@update')->name('admin.permission.update')->middleware('permission:system.permission.edit');
        //删除
        Route::delete('permission/destroy', 'PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
    });
    //菜单管理
    Route::group(['middleware' => 'permission:system.menu'], function () {
        Route::get('menu', 'MenuController@index')->name('admin.menu');
        Route::get('menu/data', 'MenuController@data')->name('admin.menu.data');
        //添加
        Route::get('menu/create', 'MenuController@create')->name('admin.menu.create')->middleware('permission:system.menu.create');
        Route::post('menu/store', 'MenuController@store')->name('admin.menu.store')->middleware('permission:system.menu.create');
        //编辑
        Route::get('menu/{id}/edit', 'MenuController@edit')->name('admin.menu.edit')->middleware('permission:system.menu.edit');
        Route::put('menu/{id}/update', 'MenuController@update')->name('admin.menu.update')->middleware('permission:system.menu.edit');
        //删除
        Route::delete('menu/destroy', 'MenuController@destroy')->name('admin.menu.destroy')->middleware('permission:system.menu.destroy');
    });
});


//资讯管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:zixun.manage']], function () {
    //分类管理
    Route::group(['middleware' => 'permission:zixun.category'], function () {
        Route::get('category/data', 'CategoryController@data')->name('admin.category.data');
        Route::get('category', 'CategoryController@index')->name('admin.category');
        //添加分类
        Route::get('category/create', 'CategoryController@create')->name('admin.category.create')->middleware('permission:zixun.category.create');
        Route::post('category/store', 'CategoryController@store')->name('admin.category.store')->middleware('permission:zixun.category.create');
        //编辑分类
        Route::get('category/{id}/edit', 'CategoryController@edit')->name('admin.category.edit')->middleware('permission:zixun.category.edit');
        Route::put('category/{id}/update', 'CategoryController@update')->name('admin.category.update')->middleware('permission:zixun.category.edit');
        //删除分类
        Route::delete('category/destroy', 'CategoryController@destroy')->name('admin.category.destroy')->middleware('permission:zixun.category.destroy');
    });
    //文章管理
    Route::group(['middleware' => 'permission:zixun.article'], function () {
        Route::get('article/data', 'ArticleController@data')->name('admin.article.data');
        Route::get('article', 'ArticleController@index')->name('admin.article');
        //添加
        Route::get('article/create', 'ArticleController@create')->name('admin.article.create')->middleware('permission:zixun.article.create');
        Route::post('article/store', 'ArticleController@store')->name('admin.article.store')->middleware('permission:zixun.article.create');
        //编辑
        Route::get('article/{id}/edit', 'ArticleController@edit')->name('admin.article.edit')->middleware('permission:zixun.article.edit');
        Route::put('article/{id}/update', 'ArticleController@update')->name('admin.article.update')->middleware('permission:zixun.article.edit');
        //删除
        Route::delete('article/destroy', 'ArticleController@destroy')->name('admin.article.destroy')->middleware('permission:zixun.article.destroy');
    });
    //标签管理
    Route::group(['middleware' => 'permission:zixun.tag'], function () {
        Route::get('tag/data', 'TagController@data')->name('admin.tag.data');
        Route::get('tag', 'TagController@index')->name('admin.tag');
        //添加
        Route::get('tag/create', 'TagController@create')->name('admin.tag.create')->middleware('permission:zixun.tag.create');
        Route::post('tag/store', 'TagController@store')->name('admin.tag.store')->middleware('permission:zixun.tag.create');
        //编辑
        Route::get('tag/{id}/edit', 'TagController@edit')->name('admin.tag.edit')->middleware('permission:zixun.tag.edit');
        Route::put('tag/{id}/update', 'TagController@update')->name('admin.tag.update')->middleware('permission:zixun.tag.edit');
        //删除
        Route::delete('tag/destroy', 'TagController@destroy')->name('admin.tag.destroy')->middleware('permission:zixun.tag.destroy');
    });
});

//配置管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:config.manage']], function () {
    //站点配置
    Route::group(['middleware' => 'permission:config.site'], function () {
        Route::get('site', 'SiteController@index')->name('admin.site');
        Route::put('site', 'SiteController@update')->name('admin.site.update')->middleware('permission:config.site.update');
    });
    //广告位
    Route::group(['middleware' => 'permission:config.position'], function () {
        Route::get('position/data', 'PositionController@data')->name('admin.position.data');
        Route::get('position', 'PositionController@index')->name('admin.position');
        //添加
        Route::get('position/create', 'PositionController@create')->name('admin.position.create')->middleware('permission:config.position.create');
        Route::post('position/store', 'PositionController@store')->name('admin.position.store')->middleware('permission:config.position.create');
        //编辑
        Route::get('position/{id}/edit', 'PositionController@edit')->name('admin.position.edit')->middleware('permission:config.position.edit');
        Route::put('position/{id}/update', 'PositionController@update')->name('admin.position.update')->middleware('permission:config.position.edit');
        //删除
        Route::delete('position/destroy', 'PositionController@destroy')->name('admin.position.destroy')->middleware('permission:config.position.destroy');
    });

    //广告信息
    Route::group(['middleware' => 'permission:config.advert'], function () {
        Route::get('advert/data', 'AdvertController@data')->name('admin.advert.data');
        Route::get('advert', 'AdvertController@index')->name('admin.advert');
        //添加
        Route::get('advert/create', 'AdvertController@create')->name('admin.advert.create')->middleware('permission:config.advert.create');
        Route::post('advert/store', 'AdvertController@store')->name('admin.advert.store')->middleware('permission:config.advert.create');
        //编辑
        Route::get('advert/{id}/edit', 'AdvertController@edit')->name('admin.advert.edit')->middleware('permission:config.advert.edit');
        Route::put('advert/{id}/update', 'AdvertController@update')->name('admin.advert.update')->middleware('permission:config.advert.edit');
        //删除
        Route::delete('advert/destroy', 'AdvertController@destroy')->name('admin.advert.destroy')->middleware('permission:config.advert.destroy');
    });

    //充值活动配置
    Route::group(['middleware' => 'permission:config.activitypay'], function () {
        //列表数据
        Route::get('activitypay', 'ActivityPayController@index')->name('admin.activitypay');
        Route::get('activitypay/data', 'ActivityPayController@data')->name('admin.activitypay.data');
        //添加
        Route::get('activitypay/create', 'ActivityPayController@create')->name('admin.activitypay.create')->middleware('permission:config.activitypay.create');
        Route::post('activitypay/store', 'ActivityPayController@store')->name('admin.activitypay.store')->middleware('permission:config.activitypay.create');
        //编辑
        Route::get('activitypay/{id}/edit', 'ActivityPayController@edit')->name('admin.activitypay.edit')->middleware('permission:config.activitypay.edit');
        Route::put('activitypay/{id}/update', 'ActivityPayController@update')->name('admin.activitypay.update')->middleware('permission:config.activitypay.edit');
        //删除
        Route::delete('activitypay/destroy', 'ActivityPayController@destroy')->name('admin.activitypay.destroy')->middleware('permission:config.activitypay.destroy');
    });

    //活动列表配置
    Route::group(['middleware' => 'permission:config.activitylist'], function () {

        //活动列表数据
        Route::get('activitylist', 'ActivityListController@index')->name('admin.activitylist');
        Route::get('activitylist/data', 'ActivityListController@data')->name('admin.activitylist.data');
        Route::get('activitylist/changesub', 'ActivityListController@change')->name('admin.activitylist.changesub');
        //添加
        Route::get('activitylist/create', 'ActivityListController@create')->name('admin.activitylist.create')->middleware('permission:config.activitylist.create');
        Route::post('activitylist/store', 'ActivityListController@store')->name('admin.activitylist.store')->middleware('permission:config.activitylist.create');
        //编辑
        Route::get('activitylist/{id}/edit', 'ActivityListController@edit')->name('admin.activitylist.edit')->middleware('permission:config.activitylist.edit');
        Route::put('activitylist/{id}/update', 'ActivityListController@update')->name('admin.activitylist.update')->middleware('permission:config.activitylist.edit');
        //删除
        Route::delete('activitylist/destroy', 'ActivityListController@destroy')->name('admin.activitylist.destroy')->middleware('permission:config.activitylist.destroy');
    });

    //支付列表配置
    Route::group(['middleware' => 'permission:config.paylists'], function () {
        //列表数据
        Route::get('paylists', 'PayListsController@index')->name('admin.paylists');
        Route::get('paylists/data', 'PayListsController@data')->name('admin.paylists.data');
        //添加
        Route::get('paylists/create', 'PayListsController@create')->name('admin.paylists.create')->middleware('permission:config.paylists.create');
        Route::post('paylists/store', 'PayListsController@store')->name('admin.paylists.store')->middleware('permission:config.paylists.create');
        //编辑
        Route::get('paylists/{id}/edit', 'PayListsController@edit')->name('admin.paylists.edit')->middleware('permission:config.paylists.edit');
        Route::put('paylists/{id}/update', 'PayListsController@update')->name('admin.paylists.update')->middleware('permission:config.paylists.edit');
        //删除
        Route::delete('paylists/destroy', 'PayListsController@destroy')->name('admin.paylists.destroy')->middleware('permission:config.paylists.destroy');
    });


    //大厅轮播图配置
    Route::group(['middleware' => 'permission:config.channel'], function () {
        Route::get('channel/data', 'ChannelController@data')->name('admin.channel.data');
        Route::get('channel', 'ChannelController@index')->name('admin.channel');
        //添加
        Route::get('channel/create', 'ChannelController@create')->name('admin.channel.create')->middleware('permission:config.channel.create');
        Route::post('channel/store', 'ChannelController@store')->name('admin.channel.store')->middleware('permission:config.channel.create');
        //编辑
        Route::get('channel/{id}/edit', 'ChannelController@edit')->name('admin.channel.edit')->middleware('permission:config.channel.edit');
        Route::put('channel/{id}/update', 'ChannelController@update')->name('admin.channel.update')->middleware('permission:config.channel.edit');
        //删除
        Route::delete('channel/destroy', 'ChannelController@destroy')->name('admin.channel.destroy')->middleware('permission:config.channel.destroy');
    });

    //用户兑换配置
    Route::group(['middleware' => 'permission:config.exchange'], function () {
        Route::get('exchange/data', 'ExchangeController@data')->name('admin.exchange.data');
        Route::get('exchange', 'ExchangeController@index')->name('admin.exchange');
        //添加
        Route::get('exchange/create', 'ExchangeController@create')->name('admin.exchange.create')->middleware('permission:config.exchange.create');
        Route::post('exchange/store', 'ExchangeController@store')->name('admin.exchange.store')->middleware('permission:config.exchange.create');
        Route::post('exchange/status', 'ExchangeController@updateStatus')->name('admin.exchange.status')->middleware('permission:config.exchange.status');
        Route::post('exchange/money', 'ExchangeController@updateMoney')->name('admin.exchange.money')->middleware('permission:config.exchange.money');
        //编辑
        Route::get('exchange/{id}/edit', 'ExchangeController@edit')->name('admin.exchange.edit')->middleware('permission:config.exchange.edit');
        Route::put('exchange/{id}/update', 'ExchangeController@update')->name('admin.exchange.update')->middleware('permission:config.exchange.edit');
        //删除
        Route::delete('exchange/destroy', 'ExchangeController@destroy')->name('admin.exchange.destroy')->middleware('permission:config.exchange.destroy');
    });

    //百人场配置
    Route::group(['middleware' => 'permission:config.hundred'], function () {
        Route::get('hundred', 'HundredController@index')->name('admin.hundred');
        Route::any('hundred/save', 'HundredController@save')->name('admin.hundred.save')->middleware('permission:config.hundred.save');
        Route::any('hundred/send', 'HundredController@send')->name('admin.hundred.send')->middleware('permission:config.hundred.send');
    });

    //捕鱼修正配置
    Route::group(['middleware' => 'permission:config.fishcorrection'], function () {
        Route::get('fishcorrection', 'FishCorrectionController@index')->name('admin.fishcorrection');
        Route::any('fishcorrection/save', 'FishCorrectionController@save')->name('admin.fishcorrection.save')->middleware('permission:config.fishcorrection.save');
        Route::any('fishcorrection/send', 'FishCorrectionController@send')->name('admin.fishcorrection.send')->middleware('permission:config.fishcorrection.send');
    });

    //捕鱼火力概率系数
    Route::group(['middleware' => 'permission:config.fishpowerrate'], function () {
        Route::get('fishpowerrate', 'FishPowerrateController@index')->name('admin.fishpowerrate');
        Route::any('fishpowerrate/save', 'FishPowerrateController@save')->name('admin.fishpowerrate.save')->middleware('permission:config.fishpowerrate.save');
        Route::any('fishpowerrate/send', 'FishPowerrateController@send')->name('admin.fishpowerrate.send')->middleware('permission:config.fishpowerrate.send');
    });

    //百人牛牛配置
    Route::group(['middleware' => 'permission:config.brnn'], function () {
        Route::get('brnn', 'BrnnController@config')->name('admin.brnn');
        Route::post('brnn/store', 'BrnnController@store')->name('admin.brnn.store');
        Route::post('brnn/send', 'BrnnController@send')->name('admin.brnn.send');
    });

    //百人牛牛十倍场配置
    Route::group(['middleware' => 'permission:config.brnnten'], function () {
        Route::get('brnnten', 'BrnnTenController@config')->name('admin.brnnten');
        Route::post('brnnten/store', 'BrnnTenController@store')->name('admin.brnnten.store');
        Route::post('brnnten/send', 'BrnnTenController@send')->name('admin.brnnten.send')->middleware('permission:config.brnnten.send');
    });


    //举报功能
    Route::group(['middleware' => 'permission:config.complaint'], function () {
        Route::get('complaint', 'ComplaintController@index')->name('admin.complaint');
        Route::any('complaint/save', 'ComplaintController@save')->name('admin.complaint.save')->middleware('permission:config.complaint.save');
    });

    //扑鱼VIP炮台配置
    Route::group(['middleware' => 'permission:config.guns'], function () {
        Route::get('guns', 'GunsController@index')->name('admin.guns');
        Route::any('guns/save', 'GunsController@save')->name('admin.guns.save')->middleware('permission:config.guns.save');
        Route::any('guns/send', 'GunsController@send')->name('admin.guns.send')->middleware('permission:config.guns.send');
    });

    //扑鱼个人用户配置
    Route::group(['middleware' => 'permission:config.fishrate'], function () {
        Route::get('fishrate', 'FishRateController@index')->name('admin.fishrate');
        Route::any('fishrate/data', 'FishRateController@data')->name('admin.fishrate.data');
        Route::any('fishrate/detail', 'FishRateController@detail')->name('admin.fishrate.detail');
        Route::any('fishrate/edit', 'FishRateController@edit')->name('admin.fishrate.edit')->middleware('permission:config.fishrate.edit');
        Route::any('fishrate/change', 'FishRateController@change')->name('admin.fishrate.change');
    });

    //捕鱼-个人命中系数控制
    Route::group(['middleware' => 'permission:config.fishplayer'], function () {
        Route::get('fishplayer', 'FishPlayerController@index')->name('admin.fishplayer');
        Route::any('fishplayer/save', 'FishPlayerController@save')->name('admin.fishplayer.save')->middleware('permission:config.fishplayer.save');
        Route::any('fishplayer/send', 'FishPlayerController@send')->name('admin.fishplayer.send')->middleware('permission:config.fishplayer.send');
    });

    //水果机配置
    Route::group(['middleware' => 'permission:config.fruit'], function () {
        Route::get('fruit', 'Hall\FruitController@index')->name('admin.fruit');
        Route::any('fruit/save', 'Hall\FruitController@save')->name('admin.fruit.save')->middleware('permission:config.fruit.save');
        Route::any('fruit/send', 'Hall\FruitController@send')->name('admin.fruit.send')->middleware('permission:config.fruit.send');
    });

    //百人牛牛系统庄家配置 -迁移
    Route::group(['middleware' => 'permission:config.brnnbanker'], function () {
        Route::get('brnnbanker', 'GameConfig\BrnnBankerController@index')->name('admin.brnnbanker');
        Route::any('brnnbanker/save', 'GameConfig\BrnnBankerController@save')->name('admin.brnnbanker.save')->middleware('permission:config.brnnbanker.save');
        Route::any('brnnbanker/send', 'GameConfig\BrnnBankerController@send')->name('admin.brnnbanker.send')->middleware('permission:config.brnnbanker.send');
    });



    //VIP等级配置
    Route::group(['middleware' => 'permission:config.vip'], function () {
        Route::get('vip/data', 'VipController@data')->name('admin.vip.data');
        Route::get('vip', 'VipController@index')->name('admin.vip');
        //添加
        Route::get('vip/create', 'VipController@create')->name('admin.vip.create')->middleware('permission:config.vip.create');
        Route::post('vip/store', 'VipController@store')->name('admin.vip.store')->middleware('permission:config.vip.create');
        //编辑
        Route::get('vip/{id}/edit', 'VipController@edit')->name('admin.vip.edit')->middleware('permission:config.vip.edit');
        Route::put('vip/{id}/update', 'VipController@update')->name('admin.vip.update')->middleware('permission:config.vip.edit');
        //删除
        Route::delete('vip/destroy', 'VipController@destroy')->name('admin.vip.destroy')->middleware('permission:config.vip.destroy');

        Route::post('vip/send', 'VipController@send')->name('admin.vip.send')->middleware('permission:config.vip.send');

        Route::post('vip/online', 'VipController@online')->name('admin.vip.online')->middleware('permission:config.vip.online');
    });

    //VIP头像框配置
    Route::group(['middleware' => 'permission:config.avatar'], function () {
        Route::get('avatar/data', 'AvatarController@data')->name('admin.avatar.data');
        Route::get('avatar', 'AvatarController@index')->name('admin.avatar');
        //添加
        Route::get('avatar/create', 'AvatarController@create')->name('admin.avatar.create')->middleware('permission:config.avatar.create');
        Route::post('avatar/store', 'AvatarController@store')->name('admin.avatar.store')->middleware('permission:config.avatar.create');
        //编辑
        Route::get('avatar/{id}/edit', 'AvatarController@edit')->name('admin.avatar.edit')->middleware('permission:config.avatar.edit');
        Route::put('avatar/{id}/update', 'AvatarController@update')->name('admin.avatar.update')->middleware('permission:config.avatar.edit');
        //删除
        Route::delete('avatar/destroy', 'AvatarController@destroy')->name('admin.avatar.destroy')->middleware('permission:config.avatar.destroy');
        //发送配置
        Route::post('avatar/send', 'AvatarController@send')->name('admin.avatar.send')->middleware('permission:config.avatar.send');

        Route::post('avatar/online', 'AvatarController@online')->name('admin.avatar.online')->middleware('permission:config.avatar.online');
        Route::post('avatar/sort', 'AvatarController@sort')->name('admin.avatar.sort')->middleware('permission:config.avatar.sort');
        Route::post('avatar/top', 'AvatarController@top')->name('admin.avatar.top')->middleware('permission:config.avatar.top');

    });

    //VIP机器人配置
    Route::group(['middleware' => 'permission:config.robot'], function () {
        Route::get('robot/data', 'RobotController@data')->name('admin.robot.data');
        Route::get('robot', 'RobotController@index')->name('admin.robot');
        //添加
        Route::get('robot/create', 'RobotController@create')->name('admin.robot.create')->middleware('permission:config.robot.create');
        Route::post('robot/store', 'RobotController@store')->name('admin.robot.store')->middleware('permission:config.robot.create');
        //编辑
        Route::get('robot/{id}/edit', 'RobotController@edit')->name('admin.robot.edit')->middleware('permission:config.robot.edit');
        Route::put('robot/{id}/update', 'RobotController@update')->name('admin.robot.update')->middleware('permission:config.robot.edit');
        //删除
        Route::delete('robot/destroy', 'RobotController@destroy')->name('admin.robot.destroy')->middleware('permission:config.robot.destroy');
        //发送配置
        Route::post('robot/send', 'RobotController@send')->name('admin.robot.send')->middleware('permission:config.robot.send');

        //机器人随机配置
        Route::get('robot/rank', 'RobotController@rank')->name('admin.robot.rank')->middleware('permission:config.robot.rank');
        Route::post('robot/rank', 'RobotController@rank')->name('admin.robot.rank')->middleware('permission:config.robot.rank');
        Route::post('robot/send_rank', 'RobotController@sendRank')->name('admin.robot.send_rank')->middleware('permission:config.robot.send_rank');
    });

    //大厅列表
    Route::group(['middleware' => 'permission:config.gamelist'], function () {
        Route::get('gamelist/data', 'GameListController@data')->name('admin.gamelist.data');
        Route::get('gamelist', 'GameListController@index')->name('admin.gamelist');
        //添加 GameListController.php
        Route::get('gamelist/create', 'GameListController@create')->name('admin.gamelist.create')->middleware('permission:config.gamelist.create');
        Route::post('gamelist/store', 'GameListController@store')->name('admin.gamelist.store')->middleware('permission:config.gamelist.create');
        //编辑
        Route::get('gamelist/{id}/edit', 'GameListController@edit')->name('admin.gamelist.edit')->middleware('permission:config.gamelist.edit');
        Route::put('gamelist/{id}/update', 'GameListController@update')->name('admin.gamelist.update')->middleware('permission:config.gamelist.edit');
        //删除
        Route::delete('gamelist/destroy', 'GameListController@destroy')->name('admin.gamelist.destroy')->middleware('permission:config.gamelist.destroy');

        Route::post('gamelist/send', 'GameListController@send')->name('admin.gamelist.send')->middleware('permission:config.gamelist.send');
    });


    //停服公告
    Route::group(['middleware' => 'permission:config.stopnotice'], function () {
        Route::get('stopnotice', 'StopNoticeController@index')->name('admin.stopnotice');
        Route::get('stopnotice/data','StopNoticeController@data')->name('admin.stopnotice.data');
        Route::get('stopnotice/index', 'StopNoticeController@index')->name('admin.stopnotice.index');

        //添加
        Route::get('stopnotice/create', 'StopNoticeController@create')->name('admin.stopnotice.create')->middleware('permission:config.stopnotice.create');
        Route::post('stopnotice/store', 'StopNoticeController@store')->name('admin.stopnotice.store')->middleware('permission:config.stopnotice.store');
        //编辑
        Route::get('stopnotice/{id}/edit', 'StopNoticeController@edit')->name('admin.stopnotice.edit')->middleware('permission:config.stopnotice.edit');
        Route::put('stopnotice/{id}/update', 'StopNoticeController@update')->name('admin.stopnotice.update')->middleware('permission:config.stopnotice.update');
        //删除
        Route::delete('stopnotice/destroy', 'StopNoticeController@destroy')->name('admin.stopnotice.destroy')->middleware('permission:config.stopnotice.destroy');
    });

    //活动ICON排序配置
    Route::group(['middleware' => 'permission:config.icon'], function () {
        Route::get('icon/data', 'IconController@data')->name('admin.icon.data');
        Route::get('icon', 'IconController@index')->name('admin.icon');
        //添加
        Route::get('icon/create', 'IconController@create')->name('admin.icon.create')->middleware('permission:config.icon.create');
        Route::post('icon/store', 'IconController@store')->name('admin.icon.store')->middleware('permission:config.icon.create');
        //编辑
        Route::get('icon/{id}/edit', 'IconController@edit')->name('admin.icon.edit')->middleware('permission:config.icon.edit');
        Route::put('icon/{id}/update', 'IconController@update')->name('admin.icon.update')->middleware('permission:config.icon.edit');
        //删除
        Route::delete('icon/destroy', 'IconController@destroy')->name('admin.icon.destroy')->middleware('permission:config.icon.destroy');

        Route::post('icon/move', 'IconController@move')->name('admin.icon.move');
    });

    //错误码配置
    Route::group(['middleware' => 'permission:config.errorcode'], function () {
        Route::get('errorcode/data', 'ErrorCodeController@data')->name('admin.errorcode.data');
        Route::get('errorcode', 'ErrorCodeController@index')->name('admin.errorcode');
        //添加
        Route::get('errorcode/create', 'ErrorCodeController@create')->name('admin.errorcode.create')->middleware('permission:config.errorcode.create');
        Route::post('errorcode/store', 'ErrorCodeController@store')->name('admin.errorcode.store')->middleware('permission:config.errorcode.create');
        //编辑
        Route::get('errorcode/{id}/edit', 'ErrorCodeController@edit')->name('admin.errorcode.edit')->middleware('permission:config.errorcode.edit');
        Route::put('errorcode/{id}/update', 'ErrorCodeController@update')->name('admin.errorcode.update')->middleware('permission:config.errorcode.edit');
        //删除
        Route::delete('errorcode/destroy', 'ErrorCodeController@destroy')->name('admin.errorcode.destroy')->middleware('permission:config.errorcode.destroy');
        //发送
        Route::post('errorcode/send', 'ErrorCodeController@send')->name('admin.errorcode.send')->middleware('permission:config.errorcode.send');
    });

    //版本管理配置
    Route::group(['middleware' => 'permission:config.version'], function () {
        Route::get('version', 'VersionController@index')->name('admin.version');
        Route::get('version/data', 'VersionController@data')->name('admin.version.data');
        //添加
        Route::get('version/create', 'VersionController@create')->name('admin.version.create')->middleware('permission:config.version.create');
        Route::any('version/store', 'VersionController@store')->name('admin.version.store')->middleware('permission:config.version.create');
        //编辑
        Route::get('version/edit', 'VersionController@edit')->name('admin.version.edit')->middleware('permission:config.version.edit');
        Route::any('version/update', 'VersionController@update')->name('admin.version.update')->middleware('permission:config.version.edit');
        //删除
        Route::delete('version/destroy', 'VersionController@destroy')->name('admin.version.destroy')->middleware('permission:config.version.destroy');
        Route::any('version/upload', 'VersionController@upload')->name('admin.version.upload');
    });




});

//会员管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:member.manage']], function () {
    //账号管理
    Route::group(['middleware' => 'permission:member.member'], function () {
        Route::get('member/data', 'MemberController@data')->name('admin.member.data');
        Route::get('member', 'MemberController@index')->name('admin.member');
        //添加
        Route::get('member/create', 'MemberController@create')->name('admin.member.create')->middleware('permission:member.member.create');
        Route::post('member/store', 'MemberController@store')->name('admin.member.store')->middleware('permission:member.member.create');
        //编辑
        Route::get('member/{id}/edit', 'MemberController@edit')->name('admin.member.edit')->middleware('permission:member.member.edit');
        Route::put('member/{id}/update', 'MemberController@update')->name('admin.member.update')->middleware('permission:member.member.edit');
        //删除
        Route::delete('member/destroy', 'MemberController@destroy')->name('admin.member.destroy')->middleware('permission:member.member.destroy');
    });
});

//消息管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:message.manage']], function () {
    //消息管理
    Route::group(['middleware' => 'permission:message.message'], function () {
        Route::get('message/data', 'MessageController@data')->name('admin.message.data');
        Route::get('message/getUser', 'MessageController@getUser')->name('admin.message.getUser');
        Route::get('message', 'MessageController@index')->name('admin.message');
        //添加
        Route::get('message/create', 'MessageController@create')->name('admin.message.create')->middleware('permission:message.message.create');
        Route::post('message/store', 'MessageController@store')->name('admin.message.store')->middleware('permission:message.message.create');
        //删除
        Route::delete('message/destroy', 'MessageController@destroy')->name('admin.message.destroy')->middleware('permission:message.message.destroy');
        //我的消息
        Route::get('mine/message', 'MessageController@mine')->name('admin.message.mine')->middleware('permission:message.message.mine');
        Route::post('message/{id}/read', 'MessageController@read')->name('admin.message.read')->middleware('permission:message.message.mine');

        Route::get('message/count', 'MessageController@getMessageCount')->name('admin.message.get_count');
    });

});


//排行榜管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:rank.manage']], function () {

    Route::group(['middleware' => 'permission:rank.manage'], function () {

        Route::get('rank/history_data', 'RankController@historyData')->name('admin.rank.history_data');
        Route::get('rank/history', 'RankController@history')->name('admin.rank.history');

        Route::get('rank/index', 'RankController@index')->name('admin.rank.index');
        Route::get('rank/config', 'RankController@config')->name('admin.rank.config');
        Route::post('rank/store', 'RankController@store')->name('admin.rank.store');
        Route::post('rank/send', 'RankController@send')->name('admin.rank.send');

    });


});

//广播系统
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:brodcast.manage']], function () {

    Route::group(['middleware' => 'permission:brodcast.manage'], function () {

//        Route::get('brodcast/index', 'BroadcastController@index')->name('admin.brodcast.index');
//        Route::get('brodcast/config', 'BroadcastController@config')->name('admin.brodcast.config');

        //查
        Route::get('brodcast/data', 'BroadcastController@data')->name('admin.brodcast.data');
        Route::get('brodcast', 'BroadcastController@index')->name('admin.brodcast');
        Route::get('brodcast/index', 'BroadcastController@index')->name('admin.brodcast.index');
        //添
        Route::get('brodcast/create', 'BroadcastController@create')->name('admin.brodcast.create');
        Route::post('brodcast/store', 'BroadcastController@store')->name('admin.brodcast.store');
        //编辑
        Route::get('brodcast/{id}/edit', 'BroadcastController@edit')->name('admin.brodcast.edit');
        Route::put('brodcast/{id}/update', 'BroadcastController@update')->name('admin.brodcast.update');
        //删除
        Route::delete('brodcast/destroy', 'BroadcastController@destroy')->name('admin.brodcast.destroy');
        //发送配置
        Route::post('brodcast/send', 'BroadcastController@send')->name('admin.brodcast.send');


        //查
        Route::get('notice/data', 'NoticeController@data')->name('admin.notice.data');
        Route::get('notice', 'NoticeController@index')->name('admin.notice');
        Route::get('notice/index', 'NoticeController@index')->name('admin.notice.index');
        //添
        Route::get('notice/create', 'NoticeController@create')->name('admin.notice.create');
        Route::post('notice/store', 'NoticeController@store')->name('admin.notice.store');
        //编辑
        Route::get('notice/{id}/edit', 'NoticeController@edit')->name('admin.notice.edit');
        Route::put('notice/{id}/update', 'NoticeController@update')->name('admin.notice.update');
        //删除
        Route::delete('notice/destroy', 'NoticeController@destroy')->name('admin.notice.destroy');
        //发送配置
        Route::post('notice/send', 'NoticeController@send')->name('admin.notice.send');

        //停服公告
//        Route::get('stopnotice', 'StopNoticeController@index')->name('admin.stopnotice.index');
//        Route::get('stopnotice/data','StopNoticeController@data')->name('admin.stopnotice.data');
//
//        //添加
//        Route::get('stopnotice/create', 'StopNoticeController@create')->name('admin.stopnotice.create');
//        Route::post('stopnotice/store', 'StopNoticeController@store')->name('admin.stopnotice.store');
//        //编辑
//        Route::get('stopnotice/{id}/edit', 'StopNoticeController@edit')->name('admin.stopnotice.edit');
//        Route::put('stopnotice/{id}/update', 'StopNoticeController@update')->name('admin.stopnotice.update');
//        //删除
//        Route::delete('stopnotice/destroy', 'StopNoticeController@destroy')->name('admin.stopnotice.destroy');
    });
});

//用户引导系统
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:lead.manage']], function () {

    Route::group(['middleware' => 'permission:lead.manage'], function () {

        Route::get('lead/index', 'LeadController@index')->name('admin.lead.index');
        Route::get('lead/trigger', 'LeadController@trigger')->name('admin.lead.trigger');
        Route::get('lead/personal', 'LeadController@personal')->name('admin.lead.personal');

        Route::post('lead/save_user_guide', 'LeadController@saveUserGuideConfig')->name('admin.lead.save_user_guide');
        Route::post('lead/save_user_trigger', 'LeadController@saveUserTriggerConfig')->name('admin.lead.save_user_trigger');
        Route::post('lead/save_personal', 'LeadController@savePersonalConfig')->name('admin.lead.save_personal');

        Route::post('lead/send_user_guide', 'LeadController@sendUserGuideConfig')->name('admin.lead.send_user_guide');
        Route::post('lead/send_user_trigger', 'LeadController@sendUserTriggerConfig')->name('admin.lead.send_user_trigger');
        Route::post('lead/send_personal', 'LeadController@sendPersonalConfig')->name('admin.lead.send_personal');

    });
});

//运营管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:operate.manage']], function () {
    //白名单-IP
    Route::group(['middleware' => 'permission:operate.whitelist'], function () {
        Route::get('whitelist/data', 'UserWhiteListController@data')->name('admin.whitelist.data');
        Route::get('whitelist', 'UserWhiteListController@index')->name('admin.whitelist');
        //添加
        Route::get('whitelist/create', 'UserWhiteListController@create')->name('admin.whitelist.create')->middleware('permission:operate.whitelist.create');
        Route::post('whitelist/store', 'UserWhiteListController@store')->name('admin.whitelist.store')->middleware('permission:operate.whitelist.create');
        //编辑
        Route::get('whitelist/{id}/edit', 'UserWhiteListController@edit')->name('admin.whitelist.edit')->middleware('permission:operate.whitelist.edit');
        Route::put('whitelist/{id}/update', 'UserWhiteListController@update')->name('admin.whitelist.update')->middleware('permission:operate.whitelist.edit');
        //删除
        Route::delete('whitelist/destroy', 'UserWhiteListController@destroy')->name('admin.whitelist.destroy')->middleware('permission:operate.whitelist.destroy');
    });
    //白名单-设备号
    Route::group(['middleware' => 'permission:operate.whiteinstall'], function () {
        Route::get('whiteinstall/data', 'UserWhiteInstallController@data')->name('admin.whiteinstall.data');
        Route::get('whiteinstall', 'UserWhiteInstallController@index')->name('admin.whiteinstall');
        //添加
        Route::get('whiteinstall/create', 'UserWhiteInstallController@create')->name('admin.whiteinstall.create')->middleware('permission:operate.whiteinstall.create');
        Route::post('whiteinstall/store', 'UserWhiteInstallController@store')->name('admin.whiteinstall.store')->middleware('permission:operate.whiteinstall.create');
        //编辑
        Route::get('whiteinstall/{id}/edit', 'UserWhiteInstallController@edit')->name('admin.whiteinstall.edit')->middleware('permission:operate.whiteinstall.edit');
        Route::put('whiteinstall/{id}/update', 'UserWhiteInstallController@update')->name('admin.whiteinstall.update')->middleware('permission:operate.whiteinstall.edit');
        //删除
        Route::delete('whiteinstall/destroy', 'UserWhiteInstallController@destroy')->name('admin.whiteinstall.destroy')->middleware('permission:operate.whiteinstall.destroy');
    });
    //银行卡转账记录
    Route::group(['middleware' => 'permission:operate.bankorder'], function () {
        Route::get('bankorder', 'Operate\OperateBankOrderController@index')->name('admin.bankorder');
        Route::get('bankorder/data', 'Operate\OperateBankOrderController@data')->name('admin.bankorder.data');
        //通过并且发货
        Route::post('bankorder/send', 'Operate\OperateBankOrderController@send')->name('admin.bankorder.send')->middleware('permission:operate.bankorder.send');
        //拒绝
        Route::post('bankorder/refuse', 'Operate\OperateBankOrderController@refuse')->name('admin.bankorder.refuse')->middleware('permission:operate.bankorder.refuse');
    });

    //订单
    Route::group(['middleware' => 'permission:operate.order'], function () {
        Route::get('order', 'Operate\OperateOrderController@index')->name('admin.order');
        Route::get('order/data', 'Operate\OperateOrderController@data')->name('admin.order.data');
        Route::get('order/orderadd', 'Operate\OperateOrderController@orderAdd')->name('admin.order.orderadd')->middleware('permission:operate.order.orderadd');
        Route::post('order/add', 'Operate\OperateOrderController@dataAdd')->name('admin.order.add');
        //废弃
        Route::post('order/destroy', 'Operate\OperateOrderController@destroy')->name('admin.order.destroy')->middleware('permission:operate.order.destroy');
    });

    //玩家头像审核
    Route::group(['middleware' => 'permission:operate.userhead'], function () {
        Route::get('userhead', 'Operate\OperateUserHeadController@index')->name('admin.userhead');
        Route::get('userhead/data', 'Operate\OperateUserHeadController@data')->name('admin.userhead.data');
        //通过
        Route::post('userhead/send', 'Operate\OperateUserHeadController@send')->name('admin.userhead.send')->middleware('permission:operate.userhead.send');
        //拒绝
        Route::post('userhead/refuse', 'Operate\OperateUserHeadController@refuse')->name('admin.userhead.refuse')->middleware('permission:operate.userhead.refuse');
    });

    //台费统计
    Route::group(['middleware' => 'permission:operate.tablefee'], function () {
        Route::get('tablefee', 'Operate\OperateTableFeeController@index')->name('admin.tablefee');
        Route::get('tablefee/data', 'Operate\OperateTableFeeController@data')->name('admin.tablefee.data');
    });

    //库存统计
    Route::group(['middleware' => 'permission:operate.stock'], function () {
        Route::get('stock', 'Operate\OperateStockController@index')->name('admin.stock');
        Route::get('stock/data', 'Operate\OperateStockController@data')->name('admin.stock.data');
    });

    //牌局记录
    Route::group(['middleware' => 'permission:operate.record'], function () {
        Route::get('record', 'Operate\OperateRecordController@index')->name('admin.record');
        Route::any('record/data', 'Operate\OperateRecordController@data')->name('admin.record.data');
        Route::any('record/detail', 'Operate\OperateRecordController@detail')->name('admin.record.detail');
    });

    //扑鱼统计
    Route::group(['middleware' => 'permission:operate.fish'], function () {
        Route::get('fish', 'Operate\OperateFishController@index')->name('admin.fish');
        Route::any('fish/data', 'Operate\OperateFishController@data')->name('admin.fish.data');
        Route::any('fish/detail', 'Operate\OperateFishController@detail')->name('admin.fish.detail');
    });

    //流水数据
    Route::group(['middleware' => 'permission:operate.goldrecord'], function () {
        Route::get('goldrecord', 'Operate\OperateGoldRecordController@index')->name('admin.goldrecord');
        Route::get('goldrecord/data', 'Operate\OperateGoldRecordController@data')->name('admin.goldrecord.data');
    });


    //产出与消耗 Output and consumption
    Route::group(['middleware' => 'permission:operate.oactotal'], function () {
        Route::get('oactotal', 'Operate\OperateOacTotalController@index')->name('admin.oactotal');
        Route::get('oactotal/data', 'Operate\OperateOacTotalController@data')->name('admin.oactotal.data');
    });

    //充值和兑换统计 recharge and exchange
    Route::group(['middleware' => 'permission:operate.raetotal'], function () {
        Route::get('raetotal', 'Operate\OperateRaeTotalController@index')->name('admin.raetotal');
        Route::get('raetotal/data', 'Operate\OperateRaeTotalController@data')->name('admin.raetotal.data');
    });

    //短信配置
    Route::group(['middleware' => 'permission:operate.note'], function () {
        Route::get('note', 'Operate\OperateNoteController@index')->name('admin.note');
        Route::get('note/data', 'Operate\OperateNoteController@data')->name('admin.note.data');
        Route::post('note/set', 'Operate\OperateNoteController@set')->name('admin.note.set')->middleware('permission:operate.note.set');
    });
    //提现记录
    Route::group(['middleware' => 'permission:operate.withdraw'], function () {
        Route::get('withdraw', 'Operate\OperateWithdrawController@index')->name('admin.withdraw');
        Route::get('withdraw/data', 'Operate\OperateWithdrawController@data')->name('admin.withdraw.data');
        Route::post('withdraw/send', 'Operate\OperateWithdrawController@send')->name('admin.withdraw.send')->middleware('permission:operate.withdraw.send');
    });

    //客服消息
    Route::group(['middleware' => 'permission:operate.customer'], function () {
        Route::get('customer', 'Operate\OperateCustomerController@index')->name('admin.customer');
        Route::get('customer/data', 'Operate\OperateCustomerController@data')->name('admin.customer.data');
        //回复
        Route::get('customer/send', 'Operate\OperateCustomerController@send')->name('admin.customer.send')->middleware('permission:operate.customer.send');
        Route::post('customer/reback', 'Operate\OperateCustomerController@reback')->name('admin.customer.reback')->middleware('permission:operate.customer.send');
        Route::post('customer/play', 'Operate\OperateCustomerController@play')->name('admin.customer.play')->middleware('permission:operate.customer.send');
    });
    //修改玩家金币
    Route::group(['middleware' => 'permission:operate.goldcoin'], function () {
        Route::get('goldcoin', 'Operate\OperateGoldcoinController@index')->name('admin.goldcoin');
        Route::get('goldcoin/data', 'Operate\OperateGoldcoinController@data')->name('admin.goldcoin.data');
        //添加修改记录
        Route::get('goldcoin/create', 'Operate\OperateGoldcoinController@create')->name('admin.goldcoin.create')->middleware('permission:operate.goldcoin.create');
        Route::post('goldcoin/store', 'Operate\OperateGoldcoinController@store')->name('admin.goldcoin.store');

    });

    //大抽奖数据统计
    Route::group(['middleware' => 'permission:operate.granddrawdata'], function () {
        Route::get('granddraw/data_count', 'Store\GranddrawController@dataCountList')->name('admin.granddraw.data_count');
        Route::get('granddraw/data_count_get', 'Store\GranddrawController@dataCountListGet')->name('admin.granddraw.data_count_get');

    });

    //大抽奖中奖名单
    Route::group(['middleware' => 'permission:operate.granddrawwin'], function () {
        Route::get('granddraw/winning', 'Store\GranddrawController@winning')->name('admin.granddraw.winning');
        Route::get('granddraw/winning_data', 'Store\GranddrawController@winningData')->name('admin.granddraw.winning_data');

    });

    //财神数据统计
    Route::group(['middleware' => 'permission:operate.mammon.stat'], function () {
        Route::get('mammon/stat', 'Store\MammonStoreController@stat')->name('admin.mammonstore.stat')->middleware('permission:operate.mammon.stat');
        Route::get('mammon/statdata', 'Store\MammonStoreController@statData')->name('admin.mammonstore.statdata');

    });

    //监控数据
    Route::group(['middleware' => 'permission:operate.warning'], function () {
        Route::get('warning', 'Operate\OperateWarningController@index')->name('admin.warning');
        Route::get('warning/data', 'Operate\OperateWarningController@data')->name('admin.warning.data');

    });

    //在线列表
    Route::group(['middleware' => 'permission:operate.onlinelist'], function () {
        Route::get('onlinelist', 'Operate\OperateOnlineListController@index')->name('admin.onlinelist');
        Route::get('onlinelist/data', 'Operate\OperateOnlineListController@data')->name('admin.onlinelist.data');

    });

    //渠道管理列表
    Route::group(['middleware' => 'permission:operate.channellist'], function () {
        Route::get('channellist', 'Operate\OperateChannelListController@index')->name('admin.channellist');
        Route::get('channellist/data', 'Operate\OperateChannelListController@data')->name('admin.channellist.data');
        //添加
        Route::get('channellist/create', 'Operate\OperateChannelListController@create')->name('admin.channellist.create')->middleware('permission:operate.channellist.create');
        Route::post('channellist/store', 'Operate\OperateChannelListController@store')->name('admin.channellist.store')->middleware('permission:operate.channellist.create');
        //编辑
        Route::get('channellist/{id}/edit', 'Operate\OperateChannelListController@edit')->name('admin.channellist.edit')->middleware('permission:operate.channellist.edit');
        Route::put('channellist/{id}/update', 'Operate\OperateChannelListController@update')->name('admin.channellist.update')->middleware('permission:operate.channellist.edit');
        //删除
        Route::delete('channellist/destroy', 'Operate\OperateChannelListController@destroy')->name('admin.channellist.destroy')->middleware('permission:operate.channellist.destroy');

    });
});

//活动运营
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:activity.manage']], function () {
    //拉新活动-排行榜
    Route::group(['middleware' => 'permission:activity.pullnew'], function () {
        Route::get('pullnew', 'Activity\ActivityPullNewController@index')->name('admin.pullnew');
        Route::get('pullnew/data', 'Activity\ActivityPullNewController@data')->name('admin.pullnew.data');

        //添加库存
        Route::post('pullnew/addstore', 'Activity\ActivityPullNewController@addstore')->name('admin.pullnew.addstore');

        //添加积分
        Route::post('pullnew/addscore', 'Activity\ActivityPullNewController@addScore')->name('admin.pullnew.addscore')->middleware('permission:activity.pullnew.addscore');
        //添加机器人
        Route::post('pullnew/addrobot', 'Activity\ActivityPullNewController@addRobot')->name('admin.pullnew.addrobot')->middleware('permission:activity.pullnew.addrobot');
    });

    //拉新活动-数据统计
    Route::group(['middleware' => 'permission:activity.pullnewdata'], function () {
        Route::get('pullnewdata', 'Activity\ActivityPullNewDataController@index')->name('admin.pullnewdata');
        Route::get('pullnewdata/data', 'Activity\ActivityPullNewDataController@data')->name('admin.pullnewdata.data');
        //添加积分
        Route::get('pullnewdata/details', 'Activity\ActivityPullNewDataController@details')->name('admin.pullnewdata.details')->middleware('permission:activity.pullnewdata.details');
    });

    //留言板
    Route::group(['middleware' => 'permission:activity.pullmessage'], function () {
        Route::get('pullmessage', 'Activity\ActivityMsssageController@index')->name('admin.pullmessage');
        Route::get('pullmessage/data', 'Activity\ActivityMsssageController@data')->name('admin.pullmessage.data');
        Route::post('pullmessage/editstatus', 'Activity\ActivityMsssageController@editStatus')->name('admin.pullmessage.editstatus')->middleware('permission:activity.pullmessage.editstatus');
        Route::post('pullmessage/editall', 'Activity\ActivityMsssageController@editAll')->name('admin.pullmessage.editall')->middleware('permission:activity.pullmessage.editall');
        Route::post('pullmessage/deleteall', 'Activity\ActivityMsssageController@deleteAll')->name('admin.pullmessage.deleteall')->middleware('permission:activity.pullmessage.deleteall');
    });
});

//库存
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:store.manage']], function () {

    //牛牛-库存控制
    Route::group(['middleware' => 'permission:store.cattlestore'], function () {
        Route::get('cattlestore', 'Store\CattleStoreController@index')->name('admin.cattlestore');
        Route::any('cattlestore/save', 'Store\CattleStoreController@save')->name('admin.cattlestore.save')->middleware('permission:store.cattlestore.save');
        Route::any('cattlestore/send', 'Store\CattleStoreController@send')->name('admin.cattlestore.send')->middleware('permission:store.cattlestore.send');
    });
    Route::get('cattlestore/list', 'Store\CattleStoreController@dataList')->name('admin.cattlestore.list')->middleware('permission:store.cattlestorelist');
    Route::get('cattlestore/data', 'Store\CattleStoreController@data')->name('admin.cattlestore.data');

    //捕鱼-库存控制
    Route::group(['middleware' => 'permission:store.fishstore'], function () {
        Route::get('fishstore', 'Store\FishStoreController@index')->name('admin.fishstore');
        Route::any('fishstore/save', 'Store\FishStoreController@save')->name('admin.fishstore.save')->middleware('permission:store.fishstore.save');
        Route::any('fishstore/send', 'Store\FishStoreController@send')->name('admin.fishstore.send')->middleware('permission:store.fishstore.send');
    });
    Route::get('fishstore/list', 'Store\FishStoreController@dataList')->name('admin.fishstore.list')->middleware('permission:store.fishstorelist');
    Route::get('fishstore/data', 'Store\FishStoreController@data')->name('admin.fishstore.data');


    //扎金花-库存控制
    Route::group(['middleware' => 'permission:store.zjhstore'], function () {
        Route::get('zjhstore', 'Store\ZjhStoreController@index')->name('admin.zjhstore');
        Route::any('zjhstore/save', 'Store\ZjhStoreController@save')->name('admin.zjhstore.save')->middleware('permission:store.zjhstore.save');
        Route::any('zjhstore/send', 'Store\ZjhStoreController@send')->name('admin.zjhstore.send')->middleware('permission:store.zjhstore.send');
    });
    Route::get('zjhstore/list', 'Store\ZjhStoreController@dataList')->name('admin.zjhstore.list')->middleware('permission:store.zjhstorelist');
    Route::get('zjhstore/data', 'Store\ZjhStoreController@data')->name('admin.zjhstore.data');


    //百人牛牛-库存控制
    Route::group(['middleware' => 'permission:store.brnnstore'], function () {
        Route::get('brnnstore', 'Store\BrnnStoreController@index')->name('admin.brnnstore');
        Route::any('brnnstore/save', 'Store\BrnnStoreController@save')->name('admin.brnnstore.save')->middleware('permission:store.brnnstore.save');
        Route::any('brnnstore/send', 'Store\BrnnStoreController@send')->name('admin.brnnstore.send')->middleware('permission:store.brnnstore.send');
    });
    Route::get('brnnstore/list', 'Store\BrnnStoreController@dataList')->name('admin.brnnstore.list')->middleware('permission:store.brnnstorelist');
    Route::get('brnnstore/data', 'Store\BrnnStoreController@data')->name('admin.brnnstore.data');

    //红黑大战-库存控制
    Route::group(['middleware' => 'permission:store.hhdzstore'], function () {
        Route::get('hhdzstore', 'Store\HhdzStoreController@index')->name('admin.hhdzstore');
        Route::any('hhdzstore/save', 'Store\HhdzStoreController@save')->name('admin.hhdzstore.save')->middleware('permission:store.hhdzstore.save');
        Route::any('hhdzstore/send', 'Store\HhdzStoreController@send')->name('admin.hhdzstore.send')->middleware('permission:store.hhdzstore.send');
    });
    Route::get('hhdzstore/list', 'Store\HhdzStoreController@dataList')->name('admin.hhdzstore.list')->middleware('permission:store.hhdzstorelist');
    Route::get('hhdzstore/data', 'Store\HhdzStoreController@data')->name('admin.hhdzstore.data');


    //财神驾到-库存控制
    Route::group(['middleware' => 'permission:store.mammonstore'], function () {
        Route::get('mammon', 'Store\MammonStoreController@index')->name('admin.mammonstore');
        Route::any('mammon/save', 'Store\MammonStoreController@save')->name('admin.mammonstore.save')->middleware('permission:store.mammonstore.save');
        Route::any('mammon/send', 'Store\MammonStoreController@send')->name('admin.mammonstore.send')->middleware('permission:store.mammonstore.send');
    });
    Route::get('mammonstore/list', 'Store\MammonStoreController@dataList')->name('admin.mammonstore.list')->middleware('permission:store.mammonstorelist');
    Route::get('mammonstore/data', 'Store\MammonStoreController@data')->name('admin.mammonstore.data');


    //欢乐足球-库存控制
    Route::group(['middleware' => 'permission:store.lfdjstore'], function () {
        Route::get('lfdjstore', 'Store\LfdjStoreController@index')->name('admin.lfdjstore');
        Route::any('lfdjstore/save', 'Store\LfdjStoreController@save')->name('admin.lfdjstore.save')->middleware('permission:store.lfdjstore.save');
        Route::any('lfdjstore/send', 'Store\LfdjStoreController@send')->name('admin.lfdjstore.send')->middleware('permission:store.lfdjstore.send');
    });
    Route::get('lfdjstore/list', 'Store\LfdjStoreController@dataList')->name('admin.lfdjstore.list')->middleware('permission:store.lfdjstorelist');
    Route::get('lfdjstore/data', 'Store\LfdjStoreController@data')->name('admin.lfdjstore.data');

    //斗地主抽水数据
    Route::get('ddzstore/list', 'Store\DdzStoreController@dataList')->name('admin.ddzstore.list')->middleware('permission:store.ddzstorelist');
    Route::get('ddzstore/data', 'Store\DdzStoreController@data')->name('admin.ddzstore.data');


    //水果机-库存控制
    Route::group(['middleware' => 'permission:store.fruitsstore'], function () {
        Route::get('fruitsstore', 'Store\FruitsStoreController@index')->name('admin.fruitsstore');
        Route::any('fruitsstore/save', 'Store\FruitsStoreController@save')->name('admin.fruitsstore.save')->middleware('permission:store.fruitsstore.save');
        Route::any('fruitsstore/send', 'Store\FruitsStoreController@send')->name('admin.fruitsstore.send')->middleware('permission:store.fruitsstore.send');
    });
    Route::get('fruitsstore/list', 'Store\FruitsStoreController@dataList')->name('admin.fruitsstore.list')->middleware('permission:store.fruitsstorelist');
    Route::get('fruitsstore/data', 'Store\FruitsStoreController@data')->name('admin.fruitsstore.data');

    //大抽奖-库存控制
    Route::group(['middleware' => 'permission:store.granddraw'], function () {
        Route::get('granddraw', 'Store\GranddrawController@index')->name('admin.granddraw');
        Route::any('granddraw/save', 'Store\GranddrawController@save')->name('admin.granddraw.save')->middleware('permission:store.granddraw.save');
        Route::any('granddraw/send', 'Store\GranddrawController@send')->name('admin.granddraw.send')->middleware('permission:store.granddraw.send');
    });
    Route::get('granddraw/list', 'Store\GranddrawController@dataList')->name('admin.granddraw.list')->middleware('permission:store.granddrawlist');
    Route::get('granddraw/data', 'Store\GranddrawController@data')->name('admin.granddraw.data');


});


//大厅
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','operatelog', 'permission:hall.manage']], function () {
    //VIP 充值
    Route::group(['middleware' => 'permission:hall.recharge'], function () {
        Route::get('recharge', 'Hall\RechargeController@index')->name('admin.recharge');
        Route::any('recharge/save', 'Hall\RechargeController@save')->name('admin.recharge.save')->middleware('permission:hall.recharge.save');
    });

    //微信客服配置
    Route::group(['middleware' => 'permission:hall.wechatservice'], function () {
        Route::get('wechatservice', 'Hall\WeChatServiceController@index')->name('admin.wechatservice');
        Route::any('wechatservice/save', 'Hall\WeChatServiceController@save')->name('admin.wechatservice.save')->middleware('permission:hall.wechatservice.save');
    });

    //周福利-返利配置
    Route::group(['middleware' => 'permission:hall.weekreward'], function () {
        Route::get('weekreward', 'Hall\WeekRewardController@index')->name('admin.weekreward');
        Route::any('weekreward/save', 'Hall\WeekRewardController@save')->name('admin.weekreward.save')->middleware('permission:hall.weekreward.save');
        Route::any('weekreward/send', 'Hall\WeekRewardController@send')->name('admin.weekreward.send')->middleware('permission:hall.weekreward.send');
    });

    //周福利-返水,兑换数据
    Route::group(['middleware' => 'permission:hall.weekrewardlist'], function () {
        Route::get('weekrewardlist', 'Hall\WeekRewardListController@index')->name('admin.weekrewardlist');
        Route::get('weekrewardlist/data', 'Hall\WeekRewardListController@data')->name('admin.weekrewardlist.data');
        Route::get('weekrewardexchange', 'Hall\WeekRewardListController@exchange')->name('admin.weekrewardexchange')->middleware('permission:hall.weekrewardexchange');
        Route::get('weekrewardexchange/data', 'Hall\WeekRewardListController@exchangeData')->name('admin.weekrewardexchange.data');
    });

    //大抽奖-玩法配置
    Route::group(['middleware' => 'permission:hall.granddraw'], function () {
        Route::get('granddraw/playlist', 'Store\GranddrawController@playlist')->name('admin.granddraw.playlist');
        Route::any('granddraw/playsave', 'Store\GranddrawController@playsave')->name('admin.granddraw.playsave')->middleware('permission:hall.granddraw.playsave');
        Route::any('granddraw/send', 'Store\GranddrawController@send')->name('admin.granddraw.send')->middleware('permission:hall.granddraw.playsend');
    });


    //财神驾到-玩法配置
    Route::group(['middleware' => 'permission:hall.mammon'], function () {
        Route::get('mammon/playlist', 'Store\MammonStoreController@playlist')->name('admin.mammon.playlist');
        Route::post('mammon/playsave', 'Store\MammonStoreController@playSave')->name('admin.mammon.playsave')->middleware('permission:hall.mammon.playsave');
        Route::post('mammon/playsend', 'Store\MammonStoreController@playSend')->name('admin.mammon.playsend')->middleware('permission:hall.mammon.playsend');
    });


    //邮件 - 迁移
    Route::group(['middleware' => 'permission:hall.email'], function () {
        //列表数据
        Route::get('email', 'Hall\EmailController@index')->name('admin.email');
        Route::get('email/data', 'Hall\EmailController@data')->name('admin.email.data');
        //添加
        Route::get('email/create', 'Hall\EmailController@create')->name('admin.email.create')->middleware('permission:hall.email.create');
        Route::any('email/store', 'Hall\EmailController@store')->name('admin.email.store');
        //编辑
        Route::get('email/edit', 'Hall\EmailController@edit')->name('admin.email.edit')->middleware('permission:hall.email.edit');
        Route::post('email/update', 'Hall\EmailController@update')->name('admin.email.update');
        Route::post('email/send', 'Hall\EmailController@send')->name('admin.email.send')->middleware('permission:hall.email.send');
        Route::any('email/detail', 'Hall\EmailController@detail')->name('admin.email.detail');
    });

    //GM后台控制 - 迁移
    Route::group(['middleware' => 'permission:hall.gmcontrol'], function () {
        Route::get('gmcontrol', 'Hall\GmController@index')->name('admin.gmcontrol');
        Route::any('gmcontrol/data', 'Hall\GmController@data')->name('admin.gmcontrol.data');

        //添加
        Route::get('gmcontrol/create', 'Hall\GmController@create')->name('admin.gmcontrol.create')->middleware('permission:hall.gmcontrol.create');
        Route::any('gmcontrol/store', 'Hall\GmController@store')->name('admin.gmcontrol.store');

        Route::any('gmcontrol/detail', 'Hall\GmController@detail')->name('admin.gmcontrol.detail');

        Route::any('gmcontrol/edit', 'Hall\GmController@edit')->name('admin.gmcontrol.edit')->middleware('permission:hall.gmcontrol.edit');
        Route::any('gmcontrol/change', 'Hall\GmController@change')->name('admin.gmcontrol.change');
        Route::any('gmcontrol/changestatus', 'Hall\GmController@changeStatus')->name('admin.gmcontrol.changeStatus');
    });


    //用户列表
    Route::group(['middleware' => 'permission:hall.userlist'], function () {
        Route::get('userlist', 'Hall\UserListController@index')->name('admin.userlist');
        Route::any('userlist/data', 'Hall\UserListController@data')->name('admin.userlist.data');
        Route::get('userlist/create', 'Hall\UserListController@create')->name('admin.userlist.create')->middleware('permission:hall.userlist.create');
        Route::any('userlist/store', 'Hall\UserListController@store')->name('admin.userlist.store');
        Route::any('userlist/detail', 'Hall\UserListController@detail')->name('admin.userlist.detail');
        Route::any('userlist/cancellock', 'Hall\UserListController@cancellock')->name('admin.userlist.cancellock');
    });

    //新人奖励
    Route::group(['middleware' => 'permission:hall.newaward'], function () {
        Route::get('newaward', 'Hall\NewAwardController@index')->name('admin.newaward');
        Route::any('newaward/save', 'Hall\NewAwardController@save')->name('admin.newaward.save')->middleware('permission:hall.newaward.save');
        Route::any('newaward/send', 'Hall\NewAwardController@send')->name('admin.newaward.send')->middleware('permission:hall.newaward.send');;
    });


    //IP黑名单
    Route::group(['middleware' => 'permission:hall.gmcontrol'], function () {
        Route::get('iplock', 'Hall\IpLockController@index')->name('admin.iplock');
        Route::any('iplock/data', 'Hall\IpLockController@data')->name('admin.iplock.data');

        //添加
        Route::get('iplock/create', 'Hall\IpLockController@create')->name('admin.iplock.create')->middleware('permission:hall.gmcontrol.create');
        Route::any('iplock/store', 'Hall\IpLockController@store')->name('admin.iplock.store');

        Route::any('iplock/edit', 'Hall\IpLockController@edit')->name('admin.iplock.edit')->middleware('permission:hall.gmcontrol.edit');
        Route::any('iplock/change', 'Hall\IpLockController@change')->name('admin.iplock.change');
        Route::any('iplock/changestatus', 'Hall\IpLockController@changeStatus')->name('admin.iplock.changeStatus');
    });

});
