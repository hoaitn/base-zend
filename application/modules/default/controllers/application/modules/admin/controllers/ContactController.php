<?php
class Admin_ContactController extends Zend_Controller_Action {
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}	

	public function indexAction() {
		$this->view->Title = "Contact list";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest()->getParam('contact_type')) {
			$params = $this->getRequest()->getParam('contact_type', 'List All');
			if ($params != 'List All') {
				$condition = array('contact_type =?' => $params);
				$_SESSION['contact_type'] = $params;
			} else {
				$condition = array();	
				$this->view->contact_type = 'List All';
				$_SESSION['contact_type'] = 'List All';
			}
			$page =  $this->getRequest()->getParam('page');	
			list ( $this->view->Pager, $this->view->Contact ) = Contact::getAll($condition,$page);
		} else {
			$page =  $this->getRequest()->getParam('page');
			$condition = array();
			list ( $this->view->Pager, $this->view->Contact ) = Contact::getAll($condition,$page);
			$_SESSION['contact_type'] = 'List All';
		}
	}
	public function viewAction(){
		$contactObj = Contact::getById($this->getRequest()->getParam('id'));
		$contactType = $this->getRequest ()->getParam('contact_type');
		$this->view->contact_type =  $contactType;
		$this->view->Contact = $contactObj;
		if (!$_SESSION['contact_type']){
			$this->view->contact_type = "List All";
		} else {
			$this->view->contact_type = $_SESSION['contact_type'];
		}
		$this->view->Title = "View detail: ".$contactObj->contact_first_name." ".$contactObj->contact_last_name;
		$this->view->headTitle ( $this->view->Title );
	}
	public function deleteAction(){
	$contactObj = Contact::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($contactObj) {
			if ($this->getRequest ()->isPost ()) {
				$contactObj->delete ();				
				$this->Member->log ( 'Delete: ' . $contactObj->contact_first_name." ".$contactObj->contact_last_name. '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Contact' );
				My_Plugin_Libs::setSplash('Contact by: <b>'.$contactObj->contact_first_name." ".$contactObj->contact_last_name.'</b> have been delete.');
				$this->_redirect ( $this->_helper->url ( 'index', 'contact', 'admin' ) );
			}
			$this->view->Contact = $contactObj;
		}
	}	
}

