<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 15:34
 * +------------------------------
 */

/**
 * 服务端 所有URL 配置
 */
return [

    'server_mail_api_url' => env('SERVER_MAIL_API_URL'),    //邮件发送
    'server_api' => env('SERVERAPI','http://192.168.1.241:8888'), //lua配置文件上传URL

    'upload_config_url' => env('SERVER_BASE_UPLOAD_URI') . '/upload', //lua配置文件上传URL

    'rank_list_url' => env('SERVER_BASE_URI') . '/rank', //排行榜数据接口

    'file_upload_address' => env('FILE_UPLOAD_ADDRESS','http://192.168.1.127:8010/index.php'),   //文件上传接口地址

    'file_upload_key' => '0fb101b1cd213fd54513e9d9d1ba459d',     //文件上传KEY

    'file_upload_upload_url' => env('FILE_UPLOAD_UPLOAD_URL','http://192.168.1.127:8010/upload'),   //文件上传url

    'note_api' => env('NOTE_API_URL','http://192.168.1.241:6690/api'),   //短信接口

    'order_api' => env('SERVER_BASE_ORDER_URI','http://192.168.1.241:6669'),   //订单相关配置

    'online_list_api' => env('SERVER_BASE_URI','http://192.168.1.241:8888').'/get_play_info',   //在线列表接口


    'packages_upload_url' => env('HOT_UPDATE_RESOURCE','http://192.168.1.131:8011'), //更新包下载URL地址

    'packages_upload_dir' => env('PACKAGES_UPLOAD_DIR','/data/html/resource/public/packages/v2/'), //更新包文件上传目录



];