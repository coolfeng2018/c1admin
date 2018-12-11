<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 11:14
 * +------------------------------
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 *
 * Class SysVipRobotModel
 * @package App\Models
 */
class DataWarningModel extends BaseModel
{


    protected $connection = 'mysql_data_center';
    protected $table = 'pack_count_warning';




    public function getTimeAttribute()
    {

        return date('Y-m-d H:i:s',$this->attributes['time']);
    }


}