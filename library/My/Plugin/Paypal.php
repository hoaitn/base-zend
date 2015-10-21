<?php
class My_Plugin_Paypal extends Zend_Controller_Plugin_Abstract {
	public $user = '';
	public $pwd = '';
	public $signature = '';
	public $token = '';
	public $payer = '';
	public $amt = '';
	public $api_url = 'https://api-3t.paypal.com/nvp/';
	public $returnURL = '';
	public $cancelURL = '';

	public function __construct($user = '', $password = '', $signature = '', $amt = '') {
		$this->user = $user;
		$this->pwd = $password;
		$this->signature = $signature;
		$this->amt = $amt;
	}

	public function SetExpressCheckout() {
		$aFields ['USER'] = $this->user;
		$aFields ['PWD'] = $this->pwd;
		$aFields ['SIGNATURE'] = $this->signature;
		$aFields ['VERSION'] = '2.3';
		$aFields ['PAYMENTACTION'] = 'Authorization';
		$aFields ['AMT'] = $this->amt;
		$aFields ['RETURNURL'] = $this->returnURL;
		$aFields ['CANCELURL'] = $this->cancelURL;
		$aFields ['METHOD'] = 'SetExpressCheckout';
		$return = $this->curl_post( $this->api_url, $aFields );
		if ($return ['ACK'] == 'Success') {
			$this->token = $return ['TOKEN'];
			return $return;
		} else {
			return false;
		}
	}

	public function GetExpressCheckoutDetails() {
		$aFields ['USER'] = $this->user;
		$aFields ['PWD'] = $this->pwd;
		$aFields ['SIGNATURE'] = $this->signature;
		$aFields ['VERSION'] = '2.3';
		$aFields ['TOKEN'] = $this->token;
		$aFields ['METHOD'] = 'GetExpressCheckoutDetails';
		$return = $this->curl_post( $this->api_url, $aFields );
		if ($return ['ACK'] == 'Success') {
			return $return;
		} else {
			return false;
		}
	}

	public function DoExpressCheckoutPayment() {
		$aFields ['USER'] = $this->user;
		$aFields ['PWD'] = $this->pwd;
		$aFields ['SIGNATURE'] = $this->signature;
		$aFields ['VERSION'] = '2.3';
		$aFields ['AMT'] = $this->amt;
		$aFields ['TOKEN'] = $this->token;
		$aFields ['PAYMENTACTION'] = 'Authorization';
		$aFields ['PAYERID'] = $this->payer;
		$aFields ['METHOD'] = 'DoExpressCheckoutPayment';
		$return = $this->curl_post( $this->api_url, $aFields );		
		return $return;
	}

	private function parseData($tmp = '') {
		$tmp = explode( '&', urldecode( $tmp ) );
		foreach ( $tmp as $value ) {
			list ( $key, $value ) = explode( '=', $value );
			$data [$key] = $value;
		}
		return $data;
	}

	/**
	 * Send a POST requst using cURL
	 * @param string $url to request
	 * @param array $post values to send
	 * @param array $options for cURL
	 * @return string
	 */
	private function curl_post($url, $post = NULL, $options = array()) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		//curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $post ) );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9) Gecko/2008052906 Firefox/3.0' );
		curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		if (! $result = curl_exec( $ch )) {
			trigger_error( curl_error( $ch ) );
		}
		curl_close( $ch );
		return $this->parseData( $result );
	}
}