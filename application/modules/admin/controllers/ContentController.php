<?php

class Admin_ContentController extends Zend_Controller_Action {
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}
	
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['content_title'] ))
			$error [] = 'Title is required!';
		if (empty ( $form ['content_detail'] ))
			$error [] = 'Content is required!';		
		return $error;
	}
	public function indexAction() {
		$this->view->Title = "Management articles";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Content ) = Content::getAll ($condition,$page);	
	}
	public function createAction() {
		$this->view->Title = "Management articles";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();						
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Content = new Content ();
				$Content->merge ( $request );
				$Content->created_date = date("Y-m-d H:i:s");
				$Content->save ();
				$this->Member->log ( 'Post:' . $Content->content_title . '(' . $Content->content_id . ')', 'Add articles' );
				My_Plugin_Libs::setSplash ( 'Create: <b>' . $Content->content_title . '</b> have been completed. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'content', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Management articles";
		$this->view->headTitle ( $this->view->Title );
		$Content = Content::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Content->merge ( $request );
				$Content->created_date = date("Y-m-d H:i:s");
				$Content->save();
				$this->Member->log ( 'Post:' . $Content->content_title . '(' . $Content->content_id  . ')', 'Edit articles' );
				My_Plugin_Libs::setSplash ( 'Edit: <b>' . $Content->content_title . '</b> have been completed. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'content', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Content = $Content;
	}
	/**
	 * Delete a Country
	 */
	public function deleteAction() {
		$Content = Content::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Content) {
			if ($this->getRequest ()->isPost ()) {
				$Content->delete ();				
				$this->Member->log ( 'Post: ' . $Content->content_title . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa' );
				My_Plugin_Libs::setSplash('Delete: <b>'.$Content->content_title.'</b> đã được xóa khỏi hệ thống.');
				$this->_redirect ( $this->_helper->url ( 'index', 'content', 'admin' ) );
			}
			$this->view->Content = $Content;
		}
	}
	/**
	 * search edit record
	 */
	public function editbysearchAction(){
		$condition =  array();
		if($this->getRequest()->isPost()){
			$textSearch = $this->getRequest()->getParam("textSearch");
			$condition  = "%".$textSearch."%";
			$Content =  Content::getByName($condition);
			if($Content){
				$this->view->Content = $Content;
			}else{
				$this->view->Content = "false";
			}
		}	
	}
	/**
	 * search delete record
	 */
	public function deletebysearchAction(){
		$condition =  array();
		if($this->getRequest()->isPost()){
			$textSearch = $this->getRequest()->getParam("textSearch");
			$condition  = "%".$textSearch."%";
			$Content =  Content::getByName($condition);
			if($Content){
				$this->view->Content = $Content;
			}else{
				$this->view->Content = "false";
			}
		}
	}
}

