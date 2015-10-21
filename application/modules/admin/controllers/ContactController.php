<?php
class Admin_ContactController extends Zend_Controller_Action {
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}	

	public function indexAction() {
		$this->view->Title = "Danh sách đặt hàng";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Contact ) = Contact::getAll($condition,$page);
	}
	public function viewAction(){
		$contactObj = Contact::getById($this->getRequest()->getParam('id'));	
		$this->view->Contact = $contactObj;		
		$this->view->Title = "Chi tiết đặt hàng: ".$contactObj->full_name;
		$this->view->headTitle ( $this->view->Title );
	}
	public function deleteAction(){
		$contactObj = Contact::getById ( $this->getRequest ()->getParam ( 'id' ) );		
		if ($this->getRequest ()->isPost ()) {
			$contactObj->delete ();				
			$this->Member->log ( 'Đặt hàng: ' . $contactObj->full_name. '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa đơn hàng' );
			My_Plugin_Libs::setSplash('Đơn hàng của: <b>'.$contactObj->full_name.'</b> đã xóa khỏi hệ thống.');
			$this->_redirect ( $this->_helper->url ( 'index', 'contact', 'admin' ) );
		}
		$this->view->Contact = $contactObj;
	}	
}

