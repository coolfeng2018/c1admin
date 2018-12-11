<?php

/**
 * 短信参数
 */
return [
    // 请求接口秘钥
    'note_api' => env('NOTE_API_URL','http://192.168.1.241:6690/api'),   //短信接口
    'note_secret' => env('NOTE_SECRET','4667848e1fdb85d19883f5dfbabe37ae'),   //短信密钥
];