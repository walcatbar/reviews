<?php

class TestController extends Zend_Controller_Action{
    public function preDispatch() {
//        echo "test pre";
    }
    
    public function indexAction(){
       $review = new Model_ReviewsModel();
       $review->setName("Tony");
       // echo "Model created: " . var_export($review,true);
    
       $this->view->review = $review;
    }
}