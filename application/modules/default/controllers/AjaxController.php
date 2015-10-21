<?php

class AjaxController extends Zend_Controller_Action {

	function preDispatch() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}

	public function customerloginAction() {
		$response ['code'] = 'Invalid ID or password.';
		$email = $this->getRequest()->getParam( 'email' );
		$password = $this->getRequest()->getParam( 'password' );
		$Customer = Customers::setCustomerLogin( $email, $password );
		if ($Customer) {
			$Customer->setLastLogin();
			$_SESSION ['Customer'] = $Customer;
			$response ['code'] = 'SUCCESS';
		}
		echo json_encode( $response );
	}

	public function customerloguotAction() {
		unset( $_SESSION ['Customer'] );
	}

	public function searchjsonAction() {		
		$keyword = strtolower( $this->getRequest()->getParam( 'term' ) );
		
		$numOfItem = ( int ) Zend_Registry::get( 'Setting' )->autocomplete_limit;
		
		if ($numOfItem > 0) {			
			list ( $Pager, $aRespon ['cities'] ) = City::getAll( array ('LOWER(city_id) || LOWER(tags) LIKE ?' => "%{$keyword}%" ), 1, $numOfItem );
			$numOfItem = $numOfItem - $Pager->getNumResults();
		}
		
		if ($numOfItem > 0) {
			//Search countries three
			$aRespon ['countries'] = Countries::getAll( array ('LOWER(countries_id) LIKE ? OR  LOWER(tags) LIKE ?' => array ("%{$keyword}%", "%{$keyword}%" ) ), $numOfItem );
			$numOfItem = $numOfItem - count( $aRespon ['countries'] );
		}
		header( 'Content-Type: text/html; charset=iso-8859-1' );
		$search = ucwords( $keyword );
		$keywords = array ($keyword, $search, ucfirst( str_replace( ' ', '', $keyword ) ), ucfirst( str_replace( ' ', '', My_Plugin_Libs::unUnicode( $keyword ) ) ) );
		$response = array ();
		$address = '';
		//rebuil to autocomplete struc
		foreach ( $aRespon as $location => $data ) {
			foreach ( $data as $Obj ) {
				$link = '';
				if ($location == 'cities') {
					$label = $Obj->name . ', ' . $Obj->Countries->name;
					$link = $Obj->getLink();
					$country = $Obj->Countries->name;
				} elseif ($location == 'countries') {
					$label = $Obj->name;
					$link = $Obj->getLink();
					$country = $Obj->name;
				} else {
					$label = $Obj->name;
					$link = $Obj->getLink();
					$country = $Obj->Countries->name;
					$address = $Obj->address;
				}
				$response [] = array ('location' => $location, 'link' => $link, 'id' => $Obj->id, 'label' => str_replace( $keywords, '<b>' . $search . '</b>', $label ), 'value' => $label, 'country' => $country, 'address' => str_replace( $keywords, '<b>' . $search . '</b>', $address ) );
			}
		}
		echo json_encode( $response );
	}	

	public function subscriptionAction() {
		$email = $this->getRequest()->getParam( 'email' );
		$validator = new Zend_Validate_EmailAddress();
		if ($validator->isValid( $email )) {
			$response ['code'] = 'SUCCESS';
			$response ['text'] = (Newsletter::checkForAdd( $email )) ? 'Your email have been add to our subscription list' : 'This email has subscription';
		} else {
			$response = array ('text' => 'You input not valid email address' );
		}
		echo Zend_Json::encode( $response );
	}

}

