<?php
class Admin_CategoryController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
        $ss = new Zend_Session_Namespace('member');
		$this->Member = $ss->__get('Member');        
	}
	
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['name'] ))
			$error [] = 'Bạn chưa nhập tên nhóm tin!';				
		return $error;
	}
	public function indexAction() {
		$this->view->Title = "Quản lý tin tức";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Newgroup ) = NewGroup::getAll ($condition,$page);
	}
	public function createAction() {
		$this->view->Title = "Quản lý tin tức";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();						
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Content = new NewGroup ();
				$Content->merge ( $request );
				$Content->save ();
				$this->Member->log ( 'Nhóm tin:' . $Content->name . '(' . $Content->id . ')', 'Tạo mới' );
				My_Plugin_Libs::setSplash ( 'Nhóm tin: <b>' . $Content->name . '</b> đã tạo thành công. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'newgroup', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Quản lý bài viết";
		$this->view->headTitle ( $this->view->Title );
		$Content = NewGroup::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Content->merge ( $request );
				$Content->save();
				$this->Member->log ( 'Nhóm tin:' . $Content->name . '(' . $Content->id  . ')', 'Sửa chữa' );
				My_Plugin_Libs::setSplash ( 'Nhóm tin: <b>' . $Content->name . '</b> đã sửa thành công. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'newgroup', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Newgroup = $Content;
	}
	/**
	 * Delete a Country
	 */
	public function deleteAction() {
		$Content = NewGroup::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Content) {
			if ($this->getRequest ()->isPost ()) {
				$Content->delete ();				
				$this->Member->log ( 'Nhóm tin: ' . $Content->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa' );
				My_Plugin_Libs::setSplash('Nhóm tin: <b>'.$Content->name.'</b> đã được xóa khỏi hệ thống.');
				$this->_redirect ( $this->_helper->url ( 'index', 'newgroup', 'admin' ) );
			}
			$this->view->Newgroup = $Content;
		}
	}
}