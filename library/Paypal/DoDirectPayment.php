<?php
global $componentManager;
if ($_POST ['doDirectPaymentReceipt'] == 1) {
	require_once SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/CallerService.php';
	/**
	 * Get required parameters from the web form for the request
	 */
	$paymentType = urlencode ( $_POST ['paymentType'] );
	$firstName = urlencode ( $_POST ['firstName'] );
	$lastName = urlencode ( $_POST ['lastName'] );
	$creditCardType = urlencode ( $_POST ['creditCardType'] );
	$creditCardNumber = urlencode ( $_POST ['creditCardNumber'] );
	$expDateMonth = urlencode ( $_POST ['expDateMonth'] );
	
	// Month must be padded with leading zero
	$padDateMonth = str_pad ( $expDateMonth, 2, '0', STR_PAD_LEFT );
	
	$expDateYear = urlencode ( $_POST ['expDateYear'] );
	$cvv2Number = urlencode ( $_POST ['cvv2Number'] );
	$address1 = urlencode ( $_POST ['address1'] );
	$address2 = urlencode ( $_POST ['address2'] );
	$city = urlencode ( $_POST ['city'] );
	$state = urlencode ( $_POST ['state'] );
	$zip = urlencode ( $_POST ['zip'] );
	$amount = urlencode ( $_POST ['amount'] );
	//$currencyCode=urlencode($_POST['currency']);
	$country = urlencode ( $_POST ['country'] );
	$currencyCode = BASE_CURRENCY;
	$paymentType = urlencode ( $_POST ['paymentType'] );
	
	/* Construct the request string that will be sent to PayPal.
	 The variable $nvpstr contains all the variables and is a
	 name value pair string with & as a delimiter */
	
	$nvpstr = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=" . $padDateMonth . $expDateYear . "&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state" . "&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyCode";
	
	/* Make the API call to PayPal, using API signature.
	 The API response is stored in an associative array called $resArray */
	
	$resArray = hash_call ( "doDirectPayment", $nvpstr );
	
	/* Display the API response back to the browser.
	 If the response from PayPal was a success, display the response parameters'
	 If the response was an error, display the errors received using APIError.php.
	 */
	
	$ack = strtoupper ( $resArray ["ACK"] );
	if ($ack != "SUCCESS") {
		$_SESSION ['reshash'] = $resArray;
		require_once (SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/APIError.php');
		global $ERR_STRING;
		echo $ERR_STRING;
		$_SESSION ['payment_check'] = 0;
		$componentManager->moduleTemplateManager->assign ( "FORM", $ERR_STRING );
	} else {
		global $componentManager;
		$_SESSION ['payment_check'] = 1;
		$msg = '<h2>Your payment has been successfully made</h2><p>Thank you very much for using our subscription service. Your order has been successfully paid via Paypal. We will review your order and update your service status accordingly.</p>';
		$componentManager->moduleTemplateManager->assign ( "FORM", $msg );
		$transID = $resArray ["TRANSACTIONID"];
	}
}
?>