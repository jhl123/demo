<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午5:32
 */

class LoginModel
{
    //数据库操作对象
    public $dc;

    public function __construct() {
        $this->dc = dc_DcModel::getDc();
    }

    public function login($userAccount,$userPassword,$clientIp) {

        $userInfo = db_UserModel::getUserInfoByWhere($this->dc,array('cs_user_account' => $userAccount));
        if($userInfo === false){
            //数据库错误
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_DB_ERROR);
        }

        if(empty($userInfo)){
            //帐号不存在
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_USER_NOT_EXIST);
        }

        $userInfo = $userInfo[0];

        if($userInfo['cs_user_pw'] != $userPassword)
        {
            //密码错误
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_PASSWORD_ERROR);
        }

        //身份验证通过，构造登陆信息

        $tokenInfo = db_TokenModel::getTokenInfoByWhere($this->dc,array('cs_user_id' => $userInfo['cs_id']));
        if($tokenInfo === false){
            //数据库错误
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_DB_ERROR);
        }

        $tokenValue = md5($userInfo['cs_id'].time());

        if(empty($tokenInfo)){
            //Token不存,在生成Token
            $tokenInfo = array(
                'cs_id' => buildId(31,'T'),
                'cs_user_id' => $userInfo['cs_id'],
                'cs_token' => $tokenValue,
                'cs_expire_time' => date('Y-m-d H:i:s',strtotime('+1 day')),
                'cs_login_ip' => $clientIp,
                'cs_create_time' => date('Y-m-d H:i:s'),
                'cs_modify_time' => date('Y-m-d H:i:s'),
            );

            $addToken = db_TokenModel::addToken($this->dc,$tokenInfo);
            if($addToken === false){
                //数据库错误
                return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_DB_ERROR);
            }
        }
        else
        {
            //Token已存,在更新Token
            $where = array("cs_user_id" => $userInfo['cs_id']);
            $update = array(
                'cs_token' => $tokenValue,
                'cs_expire_time' => date('Y-m-d H:i:s',strtotime('+1 day')),
                'cs_login_ip' => $clientIp,
                'cs_modify_time' => date('Y-m-d H:i:s'),
            );

            $modifyToken = db_TokenModel::modifyTokenByWhere($this->dc,$update,$where);
            if($modifyToken === false){
                //数据库错误
                return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_DB_ERROR);
            }

        }


        $userInfoNew = array(
            'userId' => $userInfo['cs_id'],
            'userName' => $userInfo['cs_user_name'],
            'userAccount' => $userInfo['cs_user_account'],
            'userToken' => $tokenValue,
            'userBirth' => $userInfo['cs_user_birth'],
            'loginIp' => $clientIp,
        );

        return ResponseModel::getResponse(MAIN_CODE_OK,SUB_CODE_OK,$userInfoNew);


    }

    public function tokenAuth($userId,$userToken,$clientIp)
    {

        $tokenInfo = db_TokenModel::getTokenInfoByWhere($this->dc,array('cs_user_id' => $userId));
        if($tokenInfo === false){
            //数据库错误
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_DB_ERROR);
        }


        $tokenInfoNew = array();
        foreach($tokenInfo as $item){
            if($item['cs_login_ip'] == $clientIp){
                $tokenInfoNew = $item;
            }
        }

        if(empty($tokenInfoNew)){
            //Token不存在
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_TOKEN_NOT_EXIST);
        }

        if(strtotime($tokenInfoNew['cs_expire_time']) < time()){
            //Token过期
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_TOKEN_EXPIRE);
        }

        if($tokenInfoNew['cs_token'] != $userToken){
            //Token错误
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_TOKEN_ERROR);
        }


        //Token认证成功
        return ResponseModel::getResponse(MAIN_CODE_OK,SUB_CODE_OK);

    }

    public function getUserInfo($userId)
    {
        $userInfo = db_UserModel::getUserInfoByWhere($this->dc,array('cs_id' => $userId));
        if($userInfo === false){
            //数据库错误
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_DB_ERROR);
        }

        if(empty($userInfo))
        {
            //用户不存在
            return ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_USER_NOT_EXIST);
        }

        $userInfoNew = array(
            'userAccount' => $userInfo[0]['cs_user_account'],
            'userName' => $userInfo[0]['cs_user_name'],
            'userBirth' => $userInfo[0]['cs_user_birth'],
            'createTime' => $userInfo[0]['cs_create_time'],
        );

        return ResponseModel::getResponse(MAIN_CODE_OK,SUB_CODE_OK,$userInfoNew);
    }

}