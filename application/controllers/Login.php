<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午3:47
 */

class LoginController extends Yaf_Controller_Abstract {

    public function loginAction()
    {

        //参数接收
        $params = $this->getRequest()->getparams();

        $clientIp = $_SERVER['REMOTE_ADDR'];

        //参数检查
        $mustParams = array('userAccount','userPassword');
        $lostParams = array();
        foreach ($mustParams as $item){
            if(!isset($params[$item]) || $params[$item] === '')
            $lostParams[] = $item;
        }

        if(!empty($lostParams)){
            $result = ResponseModel::getResponse(MAIN_CODE_FAIL,SUB_CODE_PARAMS_ERROR,$lostParams);
            echo json_encode($result);die;
        }


        //登陆开始
        $loginMode = new LoginModel();
        $result = $loginMode->login($params['userAccount'],$params['userPassword'],$clientIp);
        echo json_encode($result);die;

    }

}