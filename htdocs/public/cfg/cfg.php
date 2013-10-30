<?php

class Cfg {

    private $_secureIniPath = "../application/configs/secure.ini";
    private $_sessionKey = "sofghspoirghfas$@#$#*r5938t70298t7)(#*&)(*&R)@(R7f90w3847f";
    private $_cfgFilePath = "cfg.ini";
    private $_secureIniTemplatePath = "cfg/secure_ini_template.ini";
    
    private $_siteSaveConfigurationForm = "saveConfigurationForm";
    private $_siteLogOut = "logOut";
    
    public static $DOCTRINE_CONNECTION_STRING = "doctrine.connection_string";
    public static $DOCTRINE_DATABASE_NAME = "doctrine.database_name";

    public function render() {
        return $this->_checkSession() ?
                $this->_renderLoggedView() :
                $this->_renderNotLoggedView();
    }

    private function _checkSession() {
        return ($_SESSION !== null && array_key_exists($this->_sessionKey, $_SESSION));
    }

    private function _renderNotLoggedView() {
        return array_key_exists("username", $_POST) && array_key_exists("password", $_POST) ?
                $this->_processLogInForm() :
                $this->_renderLogInForm();
    }

    private function _renderLogInForm() {
        return "
            <form method='post' action='cfg.php' class='form'>
                <h2 class='form-signin-heading'>Please sign in</h2>" .
                $this->_createFormElement("", "username", "", "text", "Username") .
                $this->_createFormElement("", "password", "", "password", "Password") .
                "<button class='btn btn-large btn-primary' type='submit'>Sign in</button>
                </form>
            </form>
        ";
    }

    private function _processLogInForm() {
        $credentials = $this->_getCredentials();

        if ($credentials['username'] == $_POST['username'] && $credentials['password'] == $_POST['password'])
            $_SESSION[$this->_sessionKey] = "1";

        ob_start();
        header("Refresh: 0; url=../cfg.php");
        ob_end_flush();
    }
    
    private function _processSaveConfigurationForm() {
        $data = array();
        foreach ($_POST as $key => $value)
            $data["%%" . $key . "%%"] = $value;
        
        $saveData = str_replace(array_keys($data), array_values($data), file_get_contents($this->_secureIniTemplatePath));
        
        $file = fopen($this->_secureIniPath, "w");
        fwrite($file, $saveData);
        fclose($file);
    }

    private function _renderLoggedView() {
        
        $site = array_key_exists("site", $_GET) ? $_GET['site'] : "";
        switch ($site) {
            case $this->_siteLogOut :
                $_SESSION = array();
                header("Refresh: 0; url=../cfg.php");
                break;
            case $this->_siteSaveConfigurationForm :
                $this->_processSaveConfigurationForm();
                header("Refresh: 0; url=../cfg.php");
                break;
            default :
                return $this->_createConfigurationForm($this->_readSecureIni());
        }
    }

    private function _getCredentials() {
        return parse_ini_file($this->_cfgFilePath);
    }

    private function _readSecureIni() {
        return parse_ini_file($this->_secureIniPath);
    }

    private function _createConfigurationForm(array $data) {
        return "
            <form method='post' action='?site=" . $this->_siteSaveConfigurationForm . "' class='form configuration'>
                <h2 class='form-signin-heading'>Configuration</h2>" .
                $this->_createConfigurationFormElements($data) .
                "<button class='btn btn-large btn-primary pull-left' type='submit'>Save</button>
                <br/><br/>
            </form>
            
            <center><a href='?site=" . $this->_siteLogOut . "'><button class='btn btn-large' type=''>Sign Out</button></a></center>
        ";
    }
    
    private function _createConfigurationFormElements(array $data) {
        $elements = "";
        
        foreach (file($this->_secureIniTemplatePath) as $line) {
            $matches = array();
            preg_match('/(.*) = \"?.*/', $line, $matches);
            
            if (count($matches) != 2) {
                print_r($matches);
                throw new InvalidArgumentException("Invalid template file at " . $matches[0]);
            }
            
            
            $elements .= $this->_createFormElement(
                    $matches[1], 
                    $matches[1],
                    array_key_exists($matches[1], $data) ? $data[$matches[1]] : "",
                    "text"
                );
        }
        
        return $elements;
    }
    
    private function _createFormElement($elementLabel, $elementName, $elementValue, $elementType, $placeHolder = "") {
        $label = empty($elementLabel) ? "" : $elementLabel . ":";
        
        return "<label>" . $label . 
            "<input 
                name='" . $elementName . "' 
                type='" . $elementType . "' 
                class='input-block-level' 
                placeholder='" . $placeHolder . "' 
                value='" . $elementValue . "'
            >
        </label>";
    }
}
