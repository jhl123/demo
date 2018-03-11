<?php
/**
 * Created by PhpStorm.
 * User: jhl
 * Date: 2018/3/10
 * Time: 下午1:58
 */

class dc_DcModel
{
    static public function getDc()
    {
        $config = Yaf_Application::app()->getConfig();
        $db_config_params = $config->resources->database->params;
        if(isset($db_config_params->driver) && $db_config_params->driver === 'pdo_mysql')
        {
            $params = array(
                'dsn' => 'mysql:host='.$db_config_params->hostname.';port='.$db_config_params->port.';dbname='.$db_config_params->database,
                'username' => $db_config_params->username,
                'password' => $db_config_params->password,
                'options' => json_decode(json_encode($db_config_params->driver_options),true),
            );

            return pdo_PdoModel::getInstance($params);
        }
        else
        {
            return false;
        }
    }

}