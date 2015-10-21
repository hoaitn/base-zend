<?php

class Admin_IndexController extends Zend_Controller_Action {
	function init() {		
		if (! $_SESSION ['Member'])
			$this->_redirect ( '/admin/member/login' );			
	}
	
	public function indexAction() {
		$this->_redirect("/admin/content");
	}

}

