<?php

class TrainersController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $this->view->Title = 'Get Listed Form';
		$this->view->headTitle ( $this->view->Title );
		
		$captcha = new My_Plugin_Image();
 	    $this->view->captcha = $captcha->render($this->view);
 	    $this->view->captcha_id = $captcha->getId(); 
			 
		if ($this->getRequest ()->isPost ()) {	

			$request = $this->getRequest ()->getParams ();		    									
			$error = $this->_checkForm ( $request );
				if (count ( $error ) == 0) {
					$Contact = new Contact ();
					$Contact->merge ( $request );				
					$Contact->save ();
					My_Plugin_Libs::setSplash ( '<b>Your request have been send to us. Thank you very much!</b>' );
					$this->_redirect ( $this->_helper->url ( 'index', 'trainers', 'default' ) );
				}
			if (count ( $error )) {
				$this->view->error = $error;
			}	
		
		}
		$this->view->Contact = $Contact;	
    }
    
//    public function getGeo ($address, $city, $postcode, $stateId)
//    {
//    	$state = State::getById($stateId);
//    	$stateCode = $state->state_code;
//    	$link = $address . ',' . $city . ',' . $stateCode . ','. $postcode;
//    	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$link.',+AU&sensor=false');
//    	
//    	//$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.);
//
//    	$output = json_decode($geocode);
//
//		//$geoCode = new stdClass();
//    	if ($output->status == 'OK') {
//			$lat = $output->results[0]->geometry->location->lat;
//			$long = $output->results[0]->geometry->location->lng;
//			$geoCode = array('lat' => $lat,'lon' => $long);
//    	} else {
//    		$geoCode = array('error' => 'error');
//    	}	
//		return $geoCode;
//    }
    
	private function _checkForm($form) {
		$captcha = new My_Plugin_Image();
		$captchaID = $form['captchaID'];
		$captcha->removeImg($captchaID);
		
		$error = array ();
		if (empty ( $form ['contact_first_name'] ))
			$error [] = 'First Name is required!';		
		if (empty ( $form ['contact_last_name'] ))
			$error [] = 'Last Name is required!';		
		if (empty ( $form ['contact_email'] ))
			$error [] = 'Email is required!';
		if (empty ( $form ['contact_phone'] ))
			$error [] = 'Phone number is required!';
		if (empty ( $form ['city'] ))
			$error [] = 'City is required!';	
		if (empty ( $form ['postcode'] ))
			$error [] = 'Postcode is required!';				
		$validator = new My_Plugin_Captcha($captchaID);			
		if(!$validator->isValid($form['captcha'])){
				   $message = $validator->getMessages();
				   $error [] = current($message);				   
		}	
		return $error;
	}    
}
