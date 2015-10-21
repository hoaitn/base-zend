<?
/** PASS THE MOD BODY **/
require_once ('class/QPaypalService.php');
// Create instance paypal service
$servicePP = new QPaypalService ();
// get API Paypal of outlet
$servicePP->setAPI_UserName ( 'api_username' );
$servicePP->setAPI_Password ( 'api_password' );
$servicePP->setAPI_Signature ( 'api_signature' );
$servicePP->setAPI_Version ( 'api_version' );
/**
 * Processing payment
 */
// create session
session_start ();
if ($_POST) {	
	/**
	 * Get required parameters from the web form for the request
	 */
	$paymentType = urlencode ( $_POST ['paymentType'] );
	$firstName = urlencode ( $_POST ['first_name'] );
	$lastName = urlencode ( $_POST ['last_name'] );
	$creditCardType = urlencode ( $_POST ['credit_card_type'] );
	$creditCardNumber = urlencode ( $_POST ['cc_number'] );
	$expDateMonth = urlencode ( $_POST ['expdate_month'] );
	// Month must be padded with leading zero
	$padDateMonth = str_pad ( $expDateMonth, 2, '0', STR_PAD_LEFT );
	$expDateYear = urlencode ( $_POST ['expdate_year'] );
	$cvv2Number = urlencode ( $_POST ['cvv2_number'] );
	$address1 = urlencode ( $_POST ['address1'] );
	$address2 = urlencode ( $_POST ['address2'] );
	$countryCode = 'GB';
	$state = urlencode ( $_POST ['state'] );
	$zip = urlencode ( $_POST ['zipcode'] );
	$city = urlencode ( $_POST ['city'] );
	$currencyCode = urlencode ( $_POST ['currency_code'] );
	
	/**
	 * get offer's price
	 */	
	if(urlencode($_POST['curent_price']) == ""){
		$amount = urlencode ( $_POST ['buy_now_price'] );
	}else{
		$amount = urlencode ( $_POST['curent_price'] );	
	}
	/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */
	$nvpstr = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=" . $padDateMonth . $expDateYear . "&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state" . "&ZIP=$zip&COUNTRYCODE=$countryCode&CURRENCYCODE=$currencyCode";
	
	/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
	$resArray = $servicePP->hash_call ( "doDirectPayment", $nvpstr );
	/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
	$ack = strtoupper ( $resArray ["ACK"] );
	$_SESSION ['sf'] = $ack;
	if ($ack != "SUCCESS") {
		$_SESSION ['reshash'] = $resArray;
		require_once (SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/APIError.php');
		
		$ERR_STRING = "<h2>" . $resArray ['L_SEVERITYCODE0'] . "(" . $resArray ['L_ERRORCODE0'] . "):" . $resArray ['L_SHORTMESSAGE0'] . "</h2><p>" . $resArray ['L_LONGMESSAGE0'] . "</p><a href='" . BASEURL . "member/'></a>";
		//global $ERR_STRING;
		//update number offer buy
		echo $ERR_STRING;	
	} else {
		$transRef = $resArray ["TRANSACTIONID"];
		echo $transRef; 
	}

}
?>