<?php

class Admin_AjaxController extends Zend_Controller_Action {

	function init() {
		if (! $_SESSION ['Member'])
			$Member = new My_Plugin_Auth( $this->getRequest() );
		$this->Member = $_SESSION ['Member'];
	}

	function preDispatch() {
		$this->_helper->layout
			->disableLayout();
		$this->_helper->viewRenderer
			->setNoRender();
	}
	public function getdefaultAction() {
		$this->_helper->viewRenderer->render();
	}
}

