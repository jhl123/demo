<?php

define('APPLICATION_PATH', dirname(__FILE__));
ini_set('display_errors',1);
$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
