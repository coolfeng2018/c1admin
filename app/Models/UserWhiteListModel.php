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

class UserWhiteListModel extends BaseModel
{

    protected $table = 'user_white_list' ;

    protected $fillable = ['type', 'address', 'remarks' ,'auth'];

    //#定义是否默认维护时间，默认是true.改为false，则以下时间相关设定无效
    public $timestamps = true;
    //#此属性决定插入和取出数据库的格式，默认datetime格式，'U'是int(10)
    protected $dateFormat = 'U';


}