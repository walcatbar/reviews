<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function run() {  
        $path = APPLICATION_PATH . '/configs/config.ini';
        $config = new Zend_Config_Ini($path,'production');
        Zend_Registry::set("config", $config);
        
        $db = new Zend_Db_Adapter_Pdo_Mysql($config->database);
//        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $dbModel = new Model_DbModel($db);
        
        Zend_Registry::set('db',$dbModel);
         
        parent::run();
    }
}

