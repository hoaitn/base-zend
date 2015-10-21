<?php
class Admin_ProductgroupController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['name'] ))
			$error [] = 'Bạn chưa nhập tên nhóm sản phẩm';					
		return $error;
	}
	public function indexAction(){
		$this->view->Title = "Quản lý nhóm sản phẩm";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Productgroup ) = ProductGroup::getAll ($condition,$page);
	}
	public function createAction(){
		$this->view->Title = "Quản lý nhóm sản phẩm";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Product = new ProductGroup();
				$Product->merge ( $request );
				$Product->save ();
				$this->Member->log ( 'Nhóm sản phẩm:' . $Product->name . '(' . $Product->id . ')', 'Tạo mới' );
				My_Plugin_Libs::setSplash ( 'Nhóm sản phẩm: <b>' . $Product->name . '</b> đã tạo thành công. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'productgroup', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Quản lý nhóm sản phẩm";
		$this->view->headTitle ( $this->view->Title );
		$Product = ProductGroup::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform
			$error = $this->_checkForm ( $request );
			if (count ( $error ) == 0) {
				$Product->merge ( $request );
				$Product->save();
				$this->Member->log ( 'Nhóm sản phẩm:' . $Product->name . '(' . $Product->id  . ')', 'Sửa chữa' );
				My_Plugin_Libs::setSplash ( 'Nhóm sản phẩm: <b>' . $Product->name . '</b> đã sửa thành công. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'productgroup', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Product = $Product;
	}
	
	public function deleteAction() {
		$Product = ProductGroup::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Product) {
			if ($this->getRequest ()->isPost ()) {
				$Product->delete ();				
				$this->Member->log ( 'Nhóm sản phẩm: ' . $Product->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa' );
				My_Plugin_Libs::setSplash('Nhóm sản phẩm: <b>'.$Product->name.'</b> đã được xóa khỏi hệ thống.');
				$this->_redirect ( $this->_helper->url ( 'index', 'productgroup', 'admin' ) );
			}
			$this->view->Product = $Product;
		}
	}
}