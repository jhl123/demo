<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午4:07
 */



//API状态码定义

define('MAIN_CODE_OK',10000);                   //成功
define('SUB_CODE_OK',10001);                    //成功


define('MAIN_CODE_FAIL',20000);                 //失败
define('SUB_CODE_PARAMS_ERROR',20001);          //参数错误
define('SUB_CODE_DB_ERROR',20002);              //数据库异常
define('SUB_CODE_PASSWORD_ERROR',20003);        //密码错误
define('SUB_CODE_USER_NOT_EXIST',20004);        //用户信息不存在
define('SUB_CODE_TOKEN_NOT_EXIST',20005);       //用户Token不存在
define('SUB_CODE_TOKEN_EXPIRE',20006);          //用户Token过期
define('SUB_CODE_TOKEN_ERROR',20007);           //用户Token错误



class ResponseModel
{

    static private $codeMap = array(
        MAIN_CODE_OK                => '成功',
        SUB_CODE_OK                 => '成功',
        MAIN_CODE_FAIL              => '失败',
        SUB_CODE_PARAMS_ERROR       => '参数错误',
        SUB_CODE_DB_ERROR           => '数据库异常',
        SUB_CODE_PASSWORD_ERROR     => '密码错误',
        SUB_CODE_USER_NOT_EXIST     => '用户信息不存在',
        SUB_CODE_TOKEN_NOT_EXIST    => '用户Token不存在',
        SUB_CODE_TOKEN_EXPIRE       => '用户Token过期',
        SUB_CODE_TOKEN_ERROR        => '用户Token错误',

    );


    public static function getResponse($mainCode,$subCode,array $data = []){

        return array(
            'mainCode'  => $mainCode,
            'subCode'   => $subCode,
            'reason'    => isset(self::$codeMap[$subCode])?self::$codeMap[$subCode]:'为定义状子态码',
            'data'      => $data,
        );
    }



}