<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveDataFromErrorCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:move_data_from_error_code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '数据迁移脚本one_by_one.error_code=>c1admin.sys_error_code';

    protected $table_one_by_one = 'error_code';
    protected $table_c1admin = 'sys_error_code';
    protected $create_table = "CREATE TABLE `sys_error_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `error_code` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '错误码',
  `error_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '错误码释意',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统错误码配置';";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'starting...';
        $isTbale = DB::select("SHOW TABLES LIKE  '%".$this->table_c1admin."%'");
        if(!$isTbale){
            DB::select($this->create_table);
        }
        $count = DB::table($this->table_c1admin)->count();
        if(!$count>0){
            $insert = DB::connection(config('constants.MYSQL_ONE_BY_ONE'))->table($this->table_one_by_one)->get();
            $data = [];
            foreach ($insert as $key => $value){
                $data[$key]['error_code'] = $value->id;
                $data[$key]['error_name'] = $value->name;
                $data[$key]['created_at'] = strtotime($value->created_at);
                $data[$key]['updated_at'] = strtotime($value->updated_at);
            }
            DB::table($this->table_c1admin)->insert($data);
        }
        echo 'end...';
    }
}
