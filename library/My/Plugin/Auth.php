<?php
class My_Plugin_Auth extends Zend_Controller_Plugin_Abstract {

	public function __construct($request) 
    {
		if (count( $request->getParams() ) == 0)
			return;
		$controller = strtolower( $request->controller );
		$action = strtolower( $request->action );
		$ss = new Zend_Session_Namespace('member');
        $role = $ss->__get('Role');        
		if ($role[$controller] [$action] != 1) {
			if ($ss->__get('Member'))
				$ss->__get('Member')->log( 'Access denied: ' . $controller . '-' . $action, $controller );
                $ss = new Zend_Session_Namespace('permission');
                $ss->splash = 'You do not have permission accept to this section. Please contact Supper Administrator!';
    			header( 'location: /admin/' );               
		}
	}
}