<?php
class Default_Bootstrap extends Zend_Application_Module_Bootstrap {

	protected function _initRouter() {
		$uri = explode( '/', trim( $_SERVER ['REQUEST_URI'], '/' ) );
		if ($uri [0] != 'admin') {
			$ctrl = Zend_Controller_Front::getInstance();
			$router = $ctrl->getRouter();
			$routes = new Zend_Config_Xml( APPLICATION_PATH . '/modules/default/configs/routes.xml', null );
			
			$router->addConfig( $routes );
		}
	}
}