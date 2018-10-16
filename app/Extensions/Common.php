<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/21
 * Time: 14:07
 */
namespace App\Extensions;

trait Common
{
    function isPositiveInteger ($int) {
        return preg_match("/^[1-9]\d*$/", $int);
    }

    public function getClientIp() {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }

    function trimAll ($str) {
        $qian = [" ","　","\t","\n","\r"];
        return str_replace($qian, '', $str);
    }

    function array_value_sum () {
        $res = array();
        foreach (func_get_args() as $arr) {
            foreach ($arr as $k => $v){
                if (!isset($res[$k])){
                    $res[$k] = $v;
                }else{
                    $res[$k] += $v;
                }
            }
        }
        return $res;
    }
}