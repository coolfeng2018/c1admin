<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 21:11
 * +------------------------------
 */

namespace App\Library\Tools;


/**
 *
 * Class Covert
 * @package App\Library\Tools
 */
class Covert
{

    /**
     *  转换数组为lua脚本(封装)
     * @param $obj
     * @param int $depth
     * @param string $bool
     * @return string
     * @throws \Exception
     */
    public static function arrayToLuaStr($obj, $depth = 0, $bool = 'is_')
    {
//        return "\nreturn " . self::luaStr($obj, $depth, $bool);
        return "\nreturn " . self::convertData($obj, $depth, $bool);
    }

    /**
     * 判断是否为索引数组
     * @param $obj
     * @return bool
     */
    private static function isIndexArray($obj)
    {
        if (!is_array($obj)) {
            return false;
        }
        $len = count($obj);
        for ($i = 0; $i < $len; $i++) {
            if (!isset($obj[$i])) {
                return false;
            }
        }
        //it's a continuous array even though it's empty
        return true;
    }

    /**
     * 转换数据到lua配置
     * @param $obj
     * @param $depth
     * @param string $bool
     * @return string
     * @throws \Exception
     */
    public static function convertData($obj, $depth, $bool = 'is_')
    {
        if (self::isIndexArray($obj)) {
            $output = array("{\n");
            foreach ($obj as $key => $value) {
                ++$key;
                array_push($output, $depth > 0 && is_string($key) ? "[\"" : "[");
                array_push($output, $key);
                array_push($output, $depth > 0 && is_string($key) ? "\"] = " : "] = ");

                array_push($output, self::convertData($value, $depth + 1));
                array_push($output, ",\n");
            }
            array_push($output, str_repeat(' ', $depth));
            array_push($output, "}");
            return implode("", $output);
        } elseif (is_array($obj)) {
            $output = array("{\n");
            foreach ($obj as $key => $value) {

                //数据字段 只要是 is_ 开头的都是bool型
                if ($depth > 0 && strpos($key, $bool) !== false) {
                    $value = $value == 1 ? true : false;
                }

                array_push($output, str_repeat(' ', $depth + 1));
                array_push($output, "[");
                array_push($output, self::convertData($key, NULL));
                array_push($output, "] = ");
                array_push($output, self::convertData($value, $depth + 1));
                array_push($output, ",\n");
            }
            array_push($output, str_repeat(' ', $depth));
            array_push($output, "}");
            return implode("", $output);
        } elseif (is_bool($obj)) {
            return $obj ? "true" : "false";
        } elseif (is_float($obj)) {
            return "$obj";
        } elseif (is_int($obj) || is_numeric($obj)) {
            return $obj;
        } elseif (is_string($obj)) {
            return "\"$obj\"";
        } else {
            throw new \Exception("unknown data type" . gettype($obj));
        }
    }


    /**
     * 转换数组为lua脚本
     * @param $obj
     * @param int $depth
     * @return string
     * @throws \Exception
     */
    public static function luaStr($obj, $depth = 0, $bool = 'is_')
    {
        if (is_array($obj) && count($obj, 1) > 0) {

            $output = array(" {\n");

            foreach ($obj as $key => $value) {
                if ($depth == 0) ++$key;
                array_push($output, str_repeat(' ', $depth + 1));

                array_push($output, $depth > 0 && is_string($key) ? "[\"" : "[");
                array_push($output, $key);
                array_push($output, $depth > 0 && is_string($key) ? "\"] = " : "] = ");

                //数据字段 只要是 is_ 开头的都是bool型
                if ($depth > 0 && strpos($key, $bool) !== false) {
                    $value = $value == 1 ? true : false;
                }

                array_push($output, self::luaStr($value, $depth + 1));


                array_push($output, ",\n");
            }//end foreach

            array_push($output, str_repeat(' ', $depth));
            array_push($output, "}");

            return implode($output);

        } elseif (is_array($obj)) {

            $output = array("{\n");

            foreach ($obj as $key => $value) {
                if ($depth == 0) ++$key;
                array_push($output, str_repeat(' ', $depth + 1));
                array_push($output, "[");
                array_push($output, self::luaStr($key, 0));
                array_push($output, "] = ");
                array_push($output, self::luaStr($value, $depth + 1));
                array_push($output, ",\n");
            }

            array_push($output, str_repeat(' ', $depth));
            array_push($output, "}");

            return implode($output);
        } elseif (is_bool($obj)) {
            return $obj ? "true" : "false";
        } elseif (is_float($obj)) {
            return "$obj";
        } elseif (is_string($obj)) {
            return "\"$obj\"";
        } elseif (is_int($obj)) {
            return "$obj";
        } else {
            throw new \Exception("unknown data type" . gettype($obj));
        }
    }

}