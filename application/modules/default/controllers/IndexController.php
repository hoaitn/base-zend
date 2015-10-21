<?php

class IndexController extends Zend_Controller_Action {
	
	public function indexAction() {	
		$this->view->Title = "Home";
		$this->view->headTitle ( $this->view->Title );		
	}
	public function rightmenuAction(){	
	}
	public function breadcumAction(){
		
	}
	public function visitedAction(){
		
	}	
}