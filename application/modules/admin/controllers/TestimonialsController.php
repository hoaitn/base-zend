<?php
class Admin_TestimonialsController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}
	public function indexAction(){		
		$this->view->Title = "Testimonials";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Content ) = Content::getAll ($condition,$page);
	}
	public function  createAction(){
		$this->view->Title = "Testimonials";
		$this->view->headTitle($this->view->Title);
		if($this->getRequest()->isPost()){
			$request = $this->getRequest()->getParams();
			echo '<pre>';
			print_r($request);die();
			echo '</pre>';
		}
	}
	public function  editAction(){
	
	}
	public function  deleteAction(){
	
	}
}