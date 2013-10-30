<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    private $_config = null;

    protected function _initConfig()
    {
        $this->_config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $this->_config);
    }
    
    protected function _initSecure()
    {
        Zend_Registry::set('secure', new Zend_Config_Ini(APPLICATION_PATH . Zend_Registry::getInstance()->get("config")->security->secureIniFilePath));
    }

    protected function _initTimezone()
    {
        date_default_timezone_set($this->_config->phpSettings->timezone);
    }

    /**
     * Initialize Doctrine ORM
     * @return Doctrine_Manager
     */
    protected function _initDoctrine()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Doctrine')
                ->pushAutoloader(array('Doctrine', 'autoload'))
                ->pushAutoloader(array('Doctrine', 'modelsAutoload'))
                ->suppressNotFoundWarnings(true);

        $doctrineConfig = $this->getOption('doctrine');

//        $doctrineConfigSecure = $this->getOption();
        
//        echo "<pre>";
//        print_r($doctrineConfig);
//        print_r($doctrineConfig['connection_string']);
//        echo "</pre>";
        
        $secureConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/secure.ini');
        $secureConfigArray = $secureConfig->toArray();
        
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
        $manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true);
        $manager->setAttribute(Doctrine_Core::ATTR_EXPORT, Doctrine_Core::EXPORT_ALL);
        $manager->setCharset('utf8');
        $manager->setCollate('utf8_unicode_ci');
        $manager->openConnection(
            $this->_getSecureConfig("connection_string", $doctrineConfig, $secureConfigArray['doctrine']), 
            $this->_getSecureConfig("database_name", $doctrineConfig, $secureConfigArray['doctrine'])
        ); 
        
//        $manager->openConnection($doctrineConfig['connection_string'], $doctrineConfig['database_name']);
        Doctrine_Core::loadModels($doctrineConfig['models_path']);

        return $manager;
    }
    
    protected function _initLogger()
    {
        $this->bootstrap('log');
        $this->getResource('log')->setTimestampFormat('Y-m-d H:i:s');
        Zend_Registry::set('logFactory', $this->getResource('log'));
    }
    
    /**
     * Indicate the default autoloader should be used as a fallback or catch-all autoloader for all namespaces.
     * Usually to less problematic  load models within all modules
     */
    protected function _initExtendAutoloader()
    {
        $this->getApplication()->getAutoloader()->setFallbackAutoloader(true);
    }

//    protected function _initSessionDBHandler()
//    {
//        Zend_Session::setOptions(array('use_only_cookies' => 'on'));
//
//        Zend_Session::setSaveHandler(new Xf_Zend_Session_SaveHandler_Doctrine(array(
//                            Xf_Zend_Session_SaveHandler_Doctrine::DATA_COLUMN => 'session_data',
//                            Xf_Zend_Session_SaveHandler_Doctrine::LIFETIME_COLUMN => 'life_time',
//                            Xf_Zend_Session_SaveHandler_Doctrine::MODIFIED_COLUMN => 'updated_at',
//                            Xf_Zend_Session_SaveHandler_Doctrine::PRIMARY_KEY_COLUMN => 'id',
//                            Xf_Zend_Session_SaveHandler_Doctrine::TABLE_NAME => 'Session'
//                        )));
//    }

    /**
     * Load routing configuration
     * TODO when number of routes increase then cache it in APC
     */
    protected function _initRouter()
    {
        $router = new Zend_Controller_Router_Rewrite();
        $router->removeDefaultRoutes();

        $routerConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/router.xml');
        foreach ($routerConfig->toArray() as $routeName => $routeData)
            $router->addRoute($routeName, Zend_Controller_Router_Route_Regex::getInstance(new Zend_Config($routeData)));
        
        $router->addDefaultRoutes();
        
        $this->bootstrap('FrontController');
        $this->getResource('FrontController')->setRouter($router);
        
//        Zend_Debug::dump(Zend_Controller_Front::getInstance()->getDispatcher()->);
    }

    /**
     * Init view
     */
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype($this->_config->resources->view->doctype);
    }

//    protected function _initHelpers()
//    {
//        Zend_Controller_Action_HelperBroker::addPath(realpath(APPLICATION_PATH . '/../library/Xf/Extjs/Zend/Controller/Action/Helper'), 'Xf_Extjs_Zend_Controller_Action_Helper');
//        Zend_Controller_Action_HelperBroker::addPath(realpath(APPLICATION_PATH . '/../library/Xf/Zend/Controller/Action/Helper'), 'Xf_Zend_Controller_Action_Helper');
//        Zend_Controller_Action_HelperBroker::addPath(realpath(APPLICATION_PATH . '/models/Controller/Action/Helper'), 'Controller_Action_Helper');
//    }

//    protected function _initViewHelper()
//    {
//        $jsTemplateHelper = new Xf_Zend_View_Helper_JsTemplate();
//        $jsTemplateHelper->setPathFinder(new Xf_Zend_View_Helper_JsTemplate_PathFinder($jsTemplateHelper));
//        $jsTemplateHelper->addReplacer(new JsTemplate_Replacer_FieldIdEnum());
//        $jsTemplateHelper->addReplacer(new JsTemplate_Replacer_ParamIdEnum());
//        $jsTemplateHelper->addReplacer(new JsTemplate_Replacer_Translation());
//
//        $view = $this->getResource('view');
//        $view->registerHelper($jsTemplateHelper, 'jsTemplate');
//    }

//    /**
//     * Includes versioning information file
//     * and sets Zend_Registry value for static files versioning
//     */
//    protected function _initVersioningNumber()
//    {
//        $filePath = realpath(APPLICATION_PATH . '/configs/versionnumber.php');
//
//        if (!file_exists($filePath))
//            throw new RuntimeException('There is no version file!');
//
//        require $filePath;
//
//        if (!isset($versionNumber) || empty($versionNumber) || !is_string($versionNumber))
//            throw new RuntimeException('There is no version number information in versionNumber file!');
//
//        Zend_Registry::set('versionNumber', $versionNumber);
//    }
//
//    /**
//     * Sets Zend_Registry value for CloudFront mechanizm
//     */
//    protected function _initCloudFrontUrl()
//    {
//        Zend_Registry::set('cloudFrontUrl', $this->getOption('cloudFrontUrl'));
//    }
    
    private function _getSecureConfig($paramName, array $applicationConfig, array $secureConfig)
    {
        return array_key_exists($paramName, $secureConfig) ?
                $secureConfig[$paramName] :
                $applicationConfig[$paramName];
    }
}