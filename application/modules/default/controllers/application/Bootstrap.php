<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initAutoLoad() {
		Zend_Layout::startMvc();
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper( 'viewRenderer' );
		$viewRenderer->initView();
		$viewRenderer->view->doctype( 'XHTML1_TRANSITIONAL' );
		//Load Setting
		$Setting = new Zend_Config_Xml( APPLICATION_PATH . '/configs/setting.xml', null );
		Zend_Registry::set( 'Setting', $Setting );
	}
}


