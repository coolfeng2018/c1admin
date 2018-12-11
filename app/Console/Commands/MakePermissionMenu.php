<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakePermissionMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量添加后台菜单选项';

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
        $menu = config('permission_menu');
        if(empty($menu)){
            return false ;
        }
        $this->insertMenu($menu,DB::connection('mysql'));
        die('SUCCESS');
    }

    /**
     * 插入菜单
     * @param array $menu 菜单列表
     * @param null $db 数据库
     * @return bool
     */
    private function insertMenu($menu = [],$db=null)
    {
        $db->beginTransaction();
        foreach ($menu as $k => $v) {
            $ret = $this->insertItem($this->formatItem($v),$db);
            if(!$ret){
                $db->rollBack();
                die( __METHOD__.'insert error ') ; //跳过当前层级
            }
            if (isset($v['child']) && is_array($v['child'])) {
                $this->insertMenu($v['child'],$db);
            }
        }
        $db->commit();
        return true ;
    }

    /**
     * 格式化菜单记录
     * @param $item
     * @return array
     */
    private function formatItem($item)
    {
        $time = date('Y-m-d H:i:s');
        $tmp = [
            'name'=> isset($item['name']) ? $item['name'] : '',
            'guard_name'=>isset($item['guard_name']) ? $item['guard_name'] : 'web',
            'display_name'=>isset($item['display_name']) ? $item['display_name'] : '',
            'route'=>isset($item['route']) ? $item['route'] : '',
            'parent_id'=>isset($item['parent_id']) ? $item['parent_id'] : 0 ,
            'icon_id'=>isset($item['icon_id']) ? $item['icon_id'] : 1,
            'sort'=>isset($item['sort']) ? $item['sort'] : 0,
            'created_at'=>isset($item['created_at']) ? $item['created_at'] : $time,
            'updated_at'=>isset($item['updated_at']) ? $item['updated_at'] : $time,
        ];
        return $tmp ;
    }

    /**
     * 更新数据
     * @param $item
     * @param $db
     * @return mixed
     */
    private function insertItem($item,$db){
        $parent_id = 0 ;
        if (!empty($item['parent_id']) && is_string($item['parent_id'])) {
            $parent_id = $db->table('permissions')->where(['name' => $item['parent_id']])->value('id');
            if(empty($parent_id)){
                return false ;
            }
        }
        $item['parent_id'] = $parent_id;

        $count = $db->table('permissions')->where(['name' => $item['name']])->count('id');
        if($count > 0 ){
            $ret = $db->table('permissions')->where(['name' => $item['name']])->update($item);
        }else{
            $ret = $db->table('permissions')->insertGetId($item);
        }
        return $ret ;
    }
}
