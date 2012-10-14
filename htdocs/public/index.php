<?php

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
//    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

define('DATESTAMP', date('Y-m-d'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

if (APPLICATION_ENV !== 'production')
    error_reporting(E_ALL | E_STRICT);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
            ->run();
//try
//{
//    $application->bootstrap()
//            ->run();
//} 
//catch (Exception $exception)
//{
//    Zend_debug::dump($exception->getMessage());
//    Zend_debug::dump($exception->getTraceAsString());
//    Zend_debug::dump($exception->getTrace());
//}
//
