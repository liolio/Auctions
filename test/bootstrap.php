<?php

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../htdocs/application'));

// Define application environment
define('APPLICATION_ENV', 'test');

// Define path to core directory
define('CORE_PATH', realpath(dirname(__FILE__).'/core'));

// Define path to fixture directory
define('FIXTURE_PATH', realpath(dirname(__FILE__).'/fixture'));

define('DATESTAMP', date('Y-m-d'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(CORE_PATH),
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->getBootstrap()->bootstrap();

$options = $application->getOption('doctrine');
$cli = new Doctrine_Cli($options);
$cli->run(array(null, 'build-all-reload', '--no-confirmation'));
