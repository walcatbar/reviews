<?php
/**
 * Description of ReviewsModel
 *
 * @author walkyriabarbosa
 */

class Model_ReviewsModel {
    protected $_db;
    
    protected $_tableName = "reviews";
    protected $_name;
    protected $_email;
    protected $_title;
    protected $_comments;
    protected $_rate;
    protected $_created;


    public function __construct() {
        if(Zend_Registry::isRegistered('db')) {
            $this->_db = Zend_Registry::get('db');
        } else {
            die("ReviewsModel: could not load database from Registry");
        }
    }

    /**
     *
     * @param type $data
     * @return \ReviewsModel 
     */
    public function populateModel($data){
        if(!empty($data)){
            $this->setName($data["name"]);
            $this->setComments($data["comments"]);
            $this->setEmail($data["email"]);
            $this->setRate($data["rate"]);
            $this->setTitle($data["title"]);
            $this->setCreated($data["created"]);
        }
        return $this;
    }
 
    /**
     *
     * @return boolean 
     */
    public function saveNew(){
        $sql = "INSERT INTO " . $this->_tableName . " (name, email, title, rate, comments) 
                VALUES (:name, :email, :title, :rate, :comments)";
        $values = array(
            "name" =>$this->_name,
            "email"=>$this->_email,
            "title"=>$this->_title,
            "rate"=>$this->_rate,
            "comments"=>$this->_comments
        );
        if($this->_db->saveData($sql, $values)){

            return true;
        }else{
            return array("error" => "Could not save record.");
        }
        

    }
    
    /**
     * Select all reviews ordered by date and return an array of reviews
     * @return array 
     */
    public function getReviews(){
        $sql = "SELECT * FROM reviews ORDER BY created";
        if(!empty($this->_db)) {
            $rows = $this->_db->getData($sql);
        } else {
            die("ReviewsModel::getReviews() No Database");
        }
        return $rows;
    }
    
    //Getters
    public function getName(){
        return $this->_name;
    }

    public function getEmail(){
        return $this->_email;
    }
    
    public function getTitle(){
        return $this->_title;
    }
    
    public function getRate(){
        return $this->_rate;
    }
    
    public function getComments(){
        return $this->_comments;
    }
    public function getCreated(){
        return date("d-m-Y", $this->_date);
    }

    //Setters
    public function setName($name){
        $this->_name = $name;
    }
    
    public function setEmail($email){
        $this->_email = $email;
    }
    
    public function setTitle($title){
        $this->_title = $title;
    }
    
    public function setComments($comments){
        $this->_comments = $comments;
    }
    
    public function setRate($rate){
        $this->_rate = $rate;
    }
    public function setCreated($created){
        $this->_created = $created;
    }
}
