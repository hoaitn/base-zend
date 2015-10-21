<?php

class Admin_IndexController extends Zend_Controller_Action {
    private $_ss;
    private $_ss_permission;
	function init() {	
        $this->_ss = new Zend_Session_Namespace('member');         
		if (! $this->_ss->__get('Member'))
			$this->_redirect ( '/admin/member/login' );	       	
	}
	
	public function indexAction() {		
		$this->view->Title = "Admin - Home Page";
		$this->view->headTitle ( $this->view->Title );
		
        $this->_ss_permission = new Zend_Session_Namespace('permission');
        $this->view->error =  $this->_ss_permission->__get('splash');       
	}	
}

