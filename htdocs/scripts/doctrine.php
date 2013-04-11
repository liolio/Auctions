<?php

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', dirname(__FILE__) . '/../application');

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

date_default_timezone_set('Europe/Warsaw');

if ('development' == APPLICATION_ENV)
    error_reporting(E_ALL | E_STRICT);

/** Zend_Application */
require_once 'Zend/Application.php';

error_reporting(E_ALL | E_STRICT);

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    array(
        'config' => array(
            APPLICATION_PATH . '/configs/application.ini'
        )
    )
);

$application->getBootstrap()->bootstrap('doctrine');
$application->getBootstrap()->bootstrap('extendAutoloader');
$options = $application->getOption('doctrine');

$cli = new Doctrine_Cli($options);
$cli->run($_SERVER['argv']);
