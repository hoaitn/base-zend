<?php

class AjaxController extends Zend_Controller_Action {

	function preDispatch() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}

	private function setBooking($booking) {
		//$Session = new Zend_Session_Namespace ( 'HotelsSystem' );
		$_SESSION ['Booking'] = $booking;
	}

	private function getBooking() {
		//$Session = new Zend_Session_Namespace ( 'HotelsSystem' );
		return $_SESSION ['Booking'];
	}

	public function getgroupsbycountryAction() {
		$id = $this->getRequest()->getParam( 'country' );
		echo Zend_Json::encode( City::getOption( $id, array ('--Select--' ) ) );
	}

	public function getlocationbycityAction() {
		$id = $this->getRequest()->getParam( 'city' );
		echo Zend_Json::encode( Location::getOption( $id, array ('--Select--' ) ) );
	}

	public function checkpromotionAction() {
		$code = $this->getRequest()->getParam( 'code' );
		$room_id = $this->getRequest()->getParam( 'room_id' );
		$index = $this->getRequest()->getParam( 'index' );
		$response ['code'] = 'ERROR';
		$booking = self::getBooking();
		if ($room_id === 'hotel') {
			$Promotion = Promotion::checkPromotion( $code, $booking ['hotels_id'], date( 'Y-m-d' ), 'hotel' );
			if ($Promotion) {
				$booking ['payment'] ['promo_hotel'] = $Promotion->price;
				$response ['code'] = 'SUCCESS';
			} else {
				$booking ['payment'] ['promo_hotel'] = 0;
			}
		} else if (array_key_exists( $room_id, $booking ['rooms'] )) {
			$Promotion = Promotion::checkPromotion( $code, $room_id, date( 'Y-m-d' ) );
			if ($Promotion) {
				$booking ['rooms'] [$room_id] [$index] ['promotion_id'] = $Promotion->id;
				$booking ['rooms'] [$room_id] [$index] ['discount'] = $Promotion->price;
				$discount = 0;
				foreach ( $booking ['rooms'] as $rooms ) {
					foreach ( $rooms as $room ) {
						$discount = $discount + $room ['discount'];
					}
				}
				$booking ['payment'] ['promo_price'] = $discount;
				$response ['code'] = 'SUCCESS';
			}
		}
		$booking ['payment'] ['grand_total'] = (($booking ['payment'] ['total_price'] - ( int ) $booking ['payment'] ['promo_price'] - ( int ) $booking ['payment'] ['promo_hotel']) + $booking ['payment'] ['payment_fee_price']);
		$this->setBooking( $booking );
		echo json_encode( $response );
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
		//echo aaaaa;
		$keyword = strtolower( $this->getRequest()->getParam( 'term' ) );
		//echo "dfsdf".$keyword;
		$numOfItem = ( int ) Zend_Registry::get( 'Setting' )->autocomplete_limit;
		
		if ($numOfItem > 0) {
			//Search city second
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

	public function getbookinginfoAction() {
		$id = $this->getRequest()->getParam( 'id' );
		$Booking = Booking::getById( $id );
		$response = array ('code' => 'Request error!' );
		if ($Booking) {
			$response = $Booking->toArray();
			$response ['hotel'] = $Booking->getHotel();
			$response ['code'] = 'SUCCESS';
		}
		echo json_encode( $response );
	}

	public function getCitiesByCountryDefaultAction() {
		$id = $this->getRequest()->getParam( 'country' );
		echo Zend_Json::encode( City::getOption( $id, array ('--Select--' ) ) );
	}

	public function getpricebygroupoftourAction() {
		$response = array ();
		$tour_id = $this->getRequest()->getParam( 'tour_id' );
		$group_id = $this->getRequest()->getParam( 'group_id' );
		$Price = TourPrice::getAll( array ('tours_id=?' => $tour_id, 'price_groups_id=?' => $group_id ) )->getFirst();
		if ($Price)
			$response = $Price->toArray();
		echo Zend_Json::encode( $response );
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

