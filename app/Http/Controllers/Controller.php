<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 处理权限分类
     */
    public function tree($list=[], $pk='id', $pid = 'parent_id', $child = '_child', $root = 0)
    {
        if (empty($list)){
            $list = Permission::get()->toArray();
        }
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 统一返回 table (json)格式
     * @param string $data 返回数据
     * @param int $count 返回数据数量
     * @param int $code 返回错误码
     * @param string $err 返回错误消息
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonTable($data='',$count=0, $code=0,$err=''){
        if(0 != $code){
            $ret = array(
                'code' => $code,
                'msg'  => empty($err) ? trans("error.err_{$code}") : $err ,
                'count'=> $count,
                'data' => $data,
            );
        }else{
            $ret = array(
                'code' => $code,
                'msg'  => empty($err) ? "ok" : $err ,
                'count'=> $count,
                'data' => $data,
            );
        }
        return response()->json($ret);
    }

    /**
     * 统一返回(json)格式
     * @param string $data 返回数据
     * @param int $code 返回错误码
     * @param string $msg 返回错误消息
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data='', $code=0,$msg=''){
        if(0 != $code){
            $ret = array(
                'code' => $code,
                'msg'  => empty($msg) ? trans("error.err_{$code}") : $msg ,
                'data' => $data,
            );
        }else{
            $ret = array(
                'code' => $code,
                'msg'  => empty($msg) ? "ok" : $msg ,
                'data' => $data,
            );
        }
        return response()->json($ret);
    }
}
