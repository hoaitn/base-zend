<?php

class IndexController extends Zend_Controller_Action {
	
	public function indexAction() {		
		$this->view->Title = "Racehorse Trainers";
		$this->view->headTitle ( $this->view->Title );
		$condition = array();
		$page = $this->getRequest()->getParam('page');		
		list ( $this->view->Pager, $this->view->trainers ) = Trainer::getAll ($condition, $page, 50, $order = 'lastName,firstName');
		
	}
}