<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\12\5 0005
 * Time: 14:14
 */

namespace App\Models;

/**
 * 错误码列表
 * Class SysErrorCodeModel
 * @package App\Models
 */
class SysErrorCodeModel extends BaseModel
{
    protected $table = 'sys_error_code';
    /**
     * 自动 写入
     * @var array
     */
    protected $fillable = ['error_code', 'error_name', 'created_at', 'updated_at'];

    /**
     * 时间戳  U = int 10
     * @var string
     */
    protected $dateFormat = 'U';
}