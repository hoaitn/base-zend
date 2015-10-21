<?php

class Admin_TrainersController extends Zend_Controller_Action
{
	function init() {
		$Member = new My_Plugin_Auth( $this->getRequest() );
		$this->Member = $_SESSION ['Member'];
	}
		
	public function indexAction()
	{
		$this->view->Title = 'Trainers Listing';
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		$ordder = "trainersListId";
		list ( $this->view->Pager, $this->view->Trainers ) = Trainer::getAll ($condition,$page,20,$ordder);
		 	
	}    

    public function createAction ()
    {
        $this->view->Title = 'Trainer';
		$this->view->headTitle ( $this->view->Title );
		
		$params = $this->getRequest()->getParams();
		
		
		if ($this->getRequest()->isPost()){
			$error = $this->_checkForm ( $params );
			if (count ( $error ) == 0) {
				$latLon = $this->getRequest()->getParam('latLon');
				if ($latLon) {
					$locale = explode(',', $latLon);
				} else {
					// show address not found error
				}		
				$trainersObj = new Trainer();
				$trainersObj->merge($params);
				$trainersObj->lat = $locale[0];
				$trainersObj->lon = $locale[1];
				$trainersObj->save();
				
				$this->_redirect ( $this->_helper->url ( 'index', 'trainers', 'admin' ) );
			} else {
				$this->view->error = $error;
			}	
		}
    }
    
	public function editAction() {
		$trainers = Trainer::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform			
			$error = $this->_checkForm ( $request );
			$latLon = $this->getRequest()->getParam('latLon');
			if ($latLon) {
				$locale = explode(',', $latLon);
			} else {
				$locale[] = $trainers->lat;
				$locale[] = $trainers->lon;				
			}	
			if (count ( $error ) == 0) {
				//$latLong = $this->getGeo($params['city'],$params['postCode'],$params['stateNo']);					
				$trainers->merge ( $request );				
				$trainers->lat = $locale[0];
				$trainers->lon = $locale[1];
				$trainers->save();					
				$this->_redirect ( $this->_helper->url ( 'index', 'trainers', 'admin' ) );
			} else {
				$this->view->error = $error;
			}	
		}
		$this->view->Title = "Edit Trainer: " . $trainers->firstName . ' ' . $trainers->lastName;
		$this->view->headTitle ( $this->view->Title );
		$this->view->trainers = $trainers;
	}
	/**
	 * Delete a Country
	 */
	public function deleteAction() {
		$trainers = Trainer::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($trainers) {
			if ($this->getRequest ()->isPost ()) {
				$trainers->delete ();				
				$this->Member->log ( 'Delete: ' . $trainers->first_name . ' ' . $trainers->last_name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Trainers' );
				My_Plugin_Libs::setSplash('Posts: <b>'.$trainers->first_name . ' ' . $trainers->last_name.'</b> have been delete.');
				$this->_redirect ( $this->_helper->url ( 'index', 'trainers', 'admin' ) );
			}
			$this->view->trainers = $trainers;
		}
	}    

	/**
	 * General Latitude and Longitude from a address, city, state, postcode (zipcode)
	 */
	
//    public function getGeo ($city, $postcode, $stateId)
//    {
//    	$state = State::getById($stateId);
//    	$stateCode = $state->name;
//    	$link = $city . ',' . $stateCode . ','. $postcode;
//    	$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($link).',AU&sensor=false&region=au');    	
//    	$output = json_decode($geocode);
//		//$geoCode = new stdClass();
//    	if ($output->status == 'OK') {
//			$lat = $output->results[0]->geometry->location->lat;
//			$long = $output->results[0]->geometry->location->lng;
//			$type = $output->results[0]->types[0];
//			
//			$geoCode = array('lat' => $lat,'lon' => $long,'type' => $type);
//    	} else {
//    		$geoCode = array('error' => 'error');
//    	}	
//		return $geoCode;
//    }
//
	/**
	 * General Latitude and Longitude from a postcode (zipcode)
	 */
//	function getGeoByZipCode($zipCode){
//		$mapsApiKey = Zend_Registry::get('Setting')->GOOGLE_API_KEY;
//		$query = "http://maps.google.com.au/maps/geo?q=".urlencode($zipCode)."&output=json&key=".$mapsApiKey;
//		$data = file_get_contents($query);
//		// if data returned
//		if($data){
//			// convert into readable format
//			$data = json_decode($data);
//			$long = $data->Placemark[0]->Point->coordinates[0];
//			$lat = $data->Placemark[0]->Point->coordinates[1];
//			return array('lat'=>$lat,'lon'=>$long);
//		}else{
//			return false;
//		}
//	}    
    
    
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['firstName'] ))
			$error [] = 'First name is required.';		
		if ($form ['lastName'] == '')
			$error [] = 'Last name is required.';	
		//if (empty ( $form ['email'] ))
			//$error [] = 'Email is required.';		
		if ($form ['phone'] == '')
			$error [] = 'Phone is required.';			
		if (empty ( $form ['postCode'] ))
			$error [] = 'Postcode is required.';
		if (empty ( $form ['stateNo'] ))
			$error [] = 'State is required.';
		if (empty ( $form ['city'] ))
			$error [] = 'City is required.';				
		return $error;
	}    
}
