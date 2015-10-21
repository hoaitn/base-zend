<?php
/****************************************************
 CallerService.php

 This file uses the constants.php to get parameters needed
 to make an API call and calls the server.if you want use your
 own credentials, you have to change the constants.php

 Called by TransactionDetails.php, ReviewOrder.php,
 DoDirectPaymentReceipt.php and DoExpressCheckoutPayment.php.

 ****************************************************/
require_once SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/constants.php';

class QPaypalService {
	private $_API_UserName;
	private $_API_Password;
	private $_API_Signature;
	private $_API_Endpoint;
	private $_API_Version;
	
	/**
	 * @return the $_API_UserName
	 */
	public function getAPI_UserName() {
		return $this->_API_UserName;
	}
	
	/**
	 * @return the $_API_Password
	 */
	public function getAPI_Password() {
		return $this->_API_Password;
	}
	
	/**
	 * @return the $_API_Signature
	 */
	public function getAPI_Signature() {
		return $this->_API_Signature;
	}
	
	/**
	 * @return the $_API_Endpoint
	 */
	public function getAPI_Endpoint() {
		return $this->_API_Endpoint;
	}
	
	/**
	 * @return the $_API_Version
	 */
	public function getAPI_Version() {
		return $this->_API_Version;
	}
	
	/**
	 * @param field_type $_API_UserName
	 */
	public function setAPI_UserName($_API_UserName) {
		$this->_API_UserName = $_API_UserName;
	}
	
	/**
	 * @param field_type $_API_Password
	 */
	public function setAPI_Password($_API_Password) {
		$this->_API_Password = $_API_Password;
	}
	
	/**
	 * @param field_type $_API_Signature
	 */
	public function setAPI_Signature($_API_Signature) {
		$this->_API_Signature = $_API_Signature;
	}
	
	/**
	 * @param field_type $_API_Endpoint
	 */
	public function setAPI_Endpoint($_API_Endpoint) {
		$this->_API_Endpoint = $_API_Endpoint;
	}
	
	/**
	 * @param field_type $_API_Version
	 */
	public function setAPI_Version($_API_Version) {
		$this->_API_Version = $_API_Version;
	}
	
	/**
	 * hash_call: Function to perform the API call to PayPal using API signature
	 * @methodName is name of API  method.
	 * @nvpStr is nvp string.
	 * returns an associtive array containing the response from the server.
	 */
	
	public function hash_call($methodName, $nvpStr) {
		//declaring of global variables
		$API_Endpoint = $this->getAPI_Endpoint ();
		$version = $this->getAPI_Version ();
		$API_UserName = $this->getAPI_UserName ();
		$API_Password = $this->getAPI_Password ();
		$API_Signature = $this->getAPI_Signature ();
		global $nvp_Header;
		
		//setting the curl parameters.
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, API_ENDPOINT );
		curl_setopt ( $ch, CURLOPT_VERBOSE, 1 );
		
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
		//Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php
		if (USE_PROXY)
			curl_setopt ( $ch, CURLOPT_PROXY, PROXY_HOST . ":" . PROXY_PORT );
		
		//NVPRequest for submitting to server
		$nvpreq = "METHOD=" . urlencode ( $methodName ) . "&VERSION=" . urlencode ( $version ) . "&PWD=" . urlencode ( $API_Password ) . "&USER=" . urlencode ( $API_UserName ) . "&SIGNATURE=" . urlencode ( $API_Signature ) . $nvpStr;
		
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $nvpreq );
		
		//getting response from server
		$response = curl_exec ( $ch );
		
		//convrting NVPResponse to an Associative Array
		$nvpResArray = $this->deformatNVP ( $response );
		$nvpReqArray = $this->deformatNVP ( $nvpreq );
		$_SESSION ['nvpReqArray'] = $nvpReqArray;
		
		if (curl_errno ( $ch )) {
			// moving to display page to display curl errors
			$_SESSION ['curl_error_no'] = curl_errno ( $ch );
			$_SESSION ['curl_error_msg'] = curl_error ( $ch );
			/*$location = "APIError.php";
			 header("Location: $location");*/
			require_once (SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/APIError.php');
		} else {
			//closing the curl
			curl_close ( $ch );
		}
		
		return $nvpResArray;
	}
	
	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	 * It is usefull to search for a particular key and displaying arrays.
	 * @nvpstr is NVPString.
	 * @nvpArray is Associative Array.
	 */
	
	public function deformatNVP($nvpstr) {
		
		$intial = 0;
		$nvpArray = array ();
		
		while ( strlen ( $nvpstr ) ) {
			//postion of Key
			$keypos = strpos ( $nvpstr, '=' );
			//position of value
			$valuepos = strpos ( $nvpstr, '&' ) ? strpos ( $nvpstr, '&' ) : strlen ( $nvpstr );
			
			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval = substr ( $nvpstr, $intial, $keypos );
			$valval = substr ( $nvpstr, $keypos + 1, $valuepos - $keypos - 1 );
			//decoding the respose
			$nvpArray [urldecode ( $keyval )] = urldecode ( $valval );
			$nvpstr = substr ( $nvpstr, $valuepos + 1, strlen ( $nvpstr ) );
		}
		return $nvpArray;
	}
}
?>
