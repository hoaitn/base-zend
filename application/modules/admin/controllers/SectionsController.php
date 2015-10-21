<?php
class Admin_SectionsController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
        $ss = new Zend_Session_Namespace('member');
		$this->Member = $ss->__get('Member');        
	}
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['name'] ))
			$error [] = 'Name is required!';					
		return $error;
	}
	public function indexAction(){
		$this->view->Title = "Management sections";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Setions ) = Setions::getAll ($condition,$page);
	}
	public function createAction(){
		$this->view->Title = "Management sections";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Product = new Setions();
				$Product->merge ( $request );
				$Product->save ();
				$this->Member->log ( 'Setions:' . $Product->name . '(' . $Product->id . ')', 'Created' );
				My_Plugin_Libs::setSplash ( 'Create: <b>' . $Product->name . '</b> have been completed. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'setions', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Management sections";
		$this->view->headTitle ( $this->view->Title );
		$Product = Setions::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Product->merge ( $request );
				$Product->save();
				$this->Member->log ( 'Setions:' . $Product->name . '(' . $Product->id  . ')', 'Edited' );
				My_Plugin_Libs::setSplash ( 'Edit: <b>' . $Product->name . '</b> have been completed. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'setions', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Setions = $Product;
	}
	
	public function deleteAction() {
		$Product = Setions::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Product) {
			if ($this->getRequest ()->isPost ()) {
				$Product->delete ();				
				$this->Member->log ( 'Setions: ' . $Product->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa' );
				My_Plugin_Libs::setSplash('Delete: <b>'.$Product->name.'</b> have been completed.');
				$this->_redirect ( $this->_helper->url ( 'index', 'setions', 'admin' ) );
			}
			$this->view->Setions = $Product;
		}
	}
}