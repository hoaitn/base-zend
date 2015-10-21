<?php

class Admin_ContentController extends Zend_Controller_Action {
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}
	
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['content_title'] ))
			$error [] = 'Title of page is required!';
		if (empty ( $form ['content_detail'] ))
			$error [] = 'Detail of page is required!';		
		return $error;
	}
	public function indexAction() {
		$this->view->Title = "Management content";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Content ) = Content::getAll ($condition,$page);
	}
	public function createAction() {
		$this->view->Title = "Management content";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();						
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Content = new Content ();
				$Content->merge ( $request );
				$Content->save ();
				$this->Member->log ( 'Create:' . $Content->content_title . '(' . $Content->content_id . ')', 'Content' );
				My_Plugin_Libs::setSplash ( 'Posts: <b>' . $Content->content_title . '</b> has been created. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'content', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Management content";
		$this->view->headTitle ( $this->view->Title );
		$Content = Content::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Content->merge ( $request );
				$Content->save();
				$this->Member->log ( 'Edit:' . $Content->content_title . '(' . $Content->content_id  . ')', 'Content' );
				My_Plugin_Libs::setSplash ( 'Posts: <b>' . $Content->content_title . '</b> has been edited. ' );
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
				$this->Member->log ( 'Delete: ' . $Content->content_title . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Content' );
				My_Plugin_Libs::setSplash('Posts: <b>'.$Content->content_title.'</b> have been delete.');
				$this->_redirect ( $this->_helper->url ( 'index', 'content', 'admin' ) );
			}
			$this->view->Content = $Content;
		}
	}
}

