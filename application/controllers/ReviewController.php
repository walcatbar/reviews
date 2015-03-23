<?php

/**
 * Description of Reviews
 * Controller class for Reviews page
 * 
 * @author walkyriabarbosa
 */

class ReviewController extends Zend_Controller_Action{
    
    public function indexAction(){
        $model = new Model_ReviewsModel();
//        echo("reviewController::indexAction: model = " . var_export($model, true));
        $this->view->reviewsArray=$model->getReviews();
//        echo "reviews = ok";
        if($this->getRequest()->getParam("error",null)!=null){
            $this->view->message = $this->getRequest()->getParam("error");
        }elseif($this->getRequest()->getParam("success",null)!=null){
            $this->view->message="Review saved. Thank you.";
        }elseif($this->getRequest()->getParam("formerror",null)!=null){
            $this->view->formmessage = $this->getRequest()->getParam("formerror");
        }
//        die("Index done");
    }
    
    public function saveAction(){
        
        $validFields = $this->validateInput();
        if(isset($validFields)){
            $reviewModel = new Model_ReviewsModel();
            $reviewModel->setName($validFields["name"]);
            $reviewModel->setEmail($validFields["email"]);
            $reviewModel->setRate($validFields["rate"]);
            $reviewModel->setComments($validFields["comments"]);
            $reviewModel->setTitle($validFields["title"]);
            $result = $reviewModel->saveNew();
            $msg = "";
            if(isset($result["error"])){
                $msg = "?error=" . $result["error"];
            }elseif($result==true){
                $msg = "?success=1";
            }
            $this->_redirect("review".$msg);
        }else{
            $this->_redirect("review");
        }
        
    }
    
    /**
     * Checks if fields are empty, emails are valid and 
     * there are no html tags in the fields
     * @return array 
     */
    protected function validateInput(){
        
        $validateNotEmpty = new Zend_Validate_NotEmpty();
        //validate empty fields
        $missingField=array();
        $name=strip_tags($this->getRequest()->getParam('name'));
        if(!$validateNotEmpty->isValid($name)){
            array_push($missingField,"Name");
        }
        
        $email=$this->getRequest()->getParam('email');
        if($validateNotEmpty->isValid($email)){
            $validator = new Zend_Validate_EmailAddress();
            if(!$validator->isValid($email)){
                $msg = "?formerror=Please provide valid email address.";
                $this->_redirect("review" .$msg);
            }
        }else{
            array_push($missingField,"Email");
        }
        
        $rate=strip_tags($this->getRequest()->getParam('rate'));
        if(!$validateNotEmpty->isValid($rate)){
            array_push($missingField,"Rate");
        }
        
        $comments=  strip_tags($this->getRequest()->getParam('comments'));
        if(!$validateNotEmpty->isValid($comments)){
            array_push($missingField,"Comments");
        }
        
        $title=strip_tags($this->getRequest()->getParam('title'));
        if(!$validateNotEmpty->isValid($title)){
            array_push($missingField,"Title");
        }
        
        $msg="";
        if(count($missingField) >0){
            $msg="?formerror=Please provide these values:";
            foreach($missingField as $field){
                $msg = $msg . " " . $field . ", ";
            }
        }
        
        if($msg != ""){
            $this->_redirect("review".$msg);
        }
        
        return array(
                "name"=>$name,
                "email" => $email,
                "title" => $title,
                "rate" => $rate,
                "comments" => $comments);
    }

}
