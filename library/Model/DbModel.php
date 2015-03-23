<?php
//class Model_DbModel extends Model_Db_Abstract{
class Model_DbModel {
    public $_db;
    
    public function __construct($db) {
        $this->_db = $db;
    }    
    
    /**
     *
     * @param String
     * @return array
     * @throws Expection 
     */
    public function getData($sql){   
          $stmt = $this->_db->prepare($sql);
          $result = $stmt->execute();
          $rows = $stmt->fetchAll();
          return $rows;
    }
    
    /**
     *
     * @param String
     * @return array
     * @throws Expection 
     */
    public function saveData($sql, $values){
        $stmt = $this->_db->prepare($sql);
        $result=$stmt->execute($values);

        return $result;
        
    }
      
}
