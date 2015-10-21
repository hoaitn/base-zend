<?php
class QPaypal {
	public $paymentType;
	public function QPaypal() {
		$_SESSION ['transaction_method'] = "paypal";
	}
	public function createBillingForm($service = "DoDirectPayment", $type = "Sale", $isForReview = false) {
		global $siteMember, $componentManager;
		$this->paymentType = $type;
		require_once (SITE_ABSOLUTE_PATH . 'modules/order/classes/site_order.php');
		$order = new QSiteOrder ();
		$amount = $order->getOrderInfoSession ( "order_total" );
		$currency = $order->getOrderInfoSession ( "order_currency" );
		if ($service == "DoDirectPayment") {
			if (! IS_LIVE) {
				$cNum = '4674966765998694';
				$cVV = '962';
			}
			
			if ($isForReview) {
				$form = new QFormManager ( 'paypalForm', '', BASESURL . 'order/order-complete/', $method = "", $labelWidth = 150, $style = "", $showFormAfterSubmit = true, $showCallBackMessageInDialog = false, $formBeforeSubmitExtraScript = "", $formAfterSubmitExtraScript = "", $hasMetaDataPanel = false, $metaFormWidth = 180, $metaFormHeight = 400, $target = "_self" );
				
				$form->createHiddenField ( "paymentType", $_POST ['paymentType'] );
				$form->createHiddenField ( "doDirectPaymentReceipt", $_POST ['doDirectPaymentReceipt'] );
				$form->createHiddenField ( "firstName", $_POST ['firstName'] );
				$form->createHiddenField ( "lastName", $_POST ['lastName'] );
				$form->createHiddenField ( "creditCardType", $_POST ['creditCardType'] );
				$form->createHiddenField ( "creditCardNumber", $_POST ['creditCardNumber'] );
				$form->createHiddenField ( "expDateMonth", $_POST ['expDateMonth'] );
				$form->createHiddenField ( "expDateYear", $_POST ['expDateYear'] );
				$form->createHiddenField ( "cvv2Number", $_POST ['cvv2Number'] );
				$form->createHiddenField ( "address1", $_POST ['address1'] );
				$form->createHiddenField ( "address2", $_POST ['address2'] );
				$form->createHiddenField ( "city", $_POST ['city'] );
				$form->createHiddenField ( "zip", $_POST ['zip'] );
				$form->createHiddenField ( "country", $_POST ['country'] );
				$form->createHiddenField ( "amount", $amount );
				$detailArray = array ("order_billing_firstname" => $_POST ['firstName'], "order_billing_lastname" => $_POST ['lastName'], "order_billing_address1" => $_POST ['address1'], "order_billing_address2" => $_POST ['address2'], "order_billing_city" => $_POST ['city'], "order_billing_state" => $_POST ['state'], "order_billing_zipcode" => $_POST ['zip'], "order_billing_country" => $_POST ['country'] );
				$order->setPayerDetail ( $detailArray );
				$arrButton = array ("btnBack" => array ('overImage' => "btn-back-hover.gif", 'activeImage' => "btn-back-normal.gif", 'disabledImage' => "btn-back-disabled.gif", 'isFocus' => false, 'isDisabled' => false, 'complyWithFormReadonly' => true, 'width' => '99', 'height' => '28', 'caption' => "", 'title' => "Checkout", 'jsFunction' => 'changeInfo()', 'link' => '', 'open_link_in_new_window' => '', 'cssClass' => '', 'otherProperties' => '' ), "btnCheckout" => array ('overImage' => "btn-checkout-hover.gif", 'activeImage' => "btn-checkout-normal.gif", 'disabledImage' => "btn-checkout-disabled.gif", 'isFocus' => false, 'isDisabled' => false, 'complyWithFormReadonly' => true, 'width' => '99', 'height' => '28', 'caption' => "", 'title' => "Checkout", 'jsFunction' => 'doCheckout()', 'link' => '', 'open_link_in_new_window' => '', 'cssClass' => '', 'otherProperties' => '' ) );
				$js = '
						changeInfo=function(){
							var frm=document.getElementById("' . $form->formName . '");
							frm.action = "' . BASESURL . 'order/billing-info/";
							frm.submit();
						};
						doCheckout = function(){
							$("#btnCheckout").hide();
							$("#btnBack").hide();
							$.blockUI({ message: $("#wait_dialog_' . $form->formName . '"),' . WAITING_DIALOG_FORMAT . '});
							$("#' . $form->formName . '").submit();
						};
					';
				
				$componentManager->appendJQueryDocumentReadyStatement ( $checkOutJS );
				
				$componentManager->appendJQueryDocumentReadyStatement ( $js );
				$form->createImageButtonSet ( 'checkoutButton', $arrButton, $showFocus = false, $display = "right", $buttonSpace = 3, $transTime = BUTTON_TRANSITION_TIME, $style = '', $addToForm = true, $embeddedScript = false, $customImageFolder = "" );
				$formString = $form->show ();
			} else {
				$form = new QFormManager ( 'paypalForm', '', '', $method = "", $labelWidth = 150, $style = "", $showFormAfterSubmit = true, $showCallBackMessageInDialog = false, $formBeforeSubmitExtraScript = "", $formAfterSubmitExtraScript = "", $hasMetaDataPanel = false, $metaFormWidth = 180, $metaFormHeight = 400, $target = "_self" );
				
				$btn = $form->createImageButton ( 'btnReview', '', 'Review Order', 'btn-orderreview-hover.gif', 'btn-orderreview-normal.gif', 'btn-orderreview-disabled.gif', 149, 28, $jsFunction = "", $link = "", $linkTarget = "", $isDisabled = false, $transTime = BUTTON_TRANSITION_TIME, $style = '', $otherProperties = "", $addToForm = false, $embeddedScript = false, $complyWithFormReadonly = true );
				
				if (IS_USA) {
					if ($isForReview) {
						$form->createHiddenField ( "state", $_POST ['state'] );
					} else {
						$arrState = array ();
						$state = '
							<tr>
									<td align=right>State:</td>
									<td align=left>
										' . $form->createSimpleComboBox ( "state", "State", $value = '', $width = 150, $arrState, $promptText = "", $validator = NULL, $cssClass = '', $style = '', $otherProperties = '', $helpMessage = 'Your billing address state', $autoSort = true, $addToForm = false ) . '
									</td>
								</tr>
							';
					}
				}
				$arrCardType = array ("Visa" => "Visa", "MasterCard" => "Master Card", "Discover" => "Discover", "Amex" => "American Express" );
				for($i = 1; $i <= 12; $i ++) {
					$arrMonth [$i] = $i;
				}
				for($j = date ( "Y" ); $j < date ( "Y" ) + 6; $j ++) {
					$arrYear [$j] = $j;
				}
				$arrCountry = array ("GB" => "United Kingdom" );
				$formString = '
					<form method="POST" action="' . BASESURL . 'order/order-review/" name="DoDirectPaymentForm">
					<input type=hidden name=paymentType value="' . $this->paymentType . '" />
					<input type=hidden name="doDirectPaymentReceipt" value="1" />
					<table width="100%">
						<tr>
							<td align=left>' . $form->createTextBox ( "firstName", "First name", ($_POST ['firstName'] ? $_POST ['firstName'] : $siteMember->getMemberAttribute ( "member_firstname" )), $isValueUnique = false, $width = 250, $maxChars = 50, $validator = "required:true;messages:{required:'First name is required!'}", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'Your billing address first name', $addToForm = false ) . '</td>
						</tr>
						<tr>
							<td align=left>' . $form->createTextBox ( "lastName", "Last name", ($_POST ['lastName'] ? $_POST ['lastName'] : $siteMember->getMemberAttribute ( "member_lastname" )), $isValueUnique = false, $width = 250, $maxChars = 50, $validator = "required:true;messages:{required:'Last name is required!'}", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'Your billing address last name', $addToForm = false ) . '</td>
						</tr>
						<tr>
							<td align=left>
								' . $form->createSimpleComboBox ( "creditCardType", "Cart type", $value = $_POST ['creditCardType'], $width = 150, $arrCardType, $promptText = "", $validator = NULL, $cssClass = '', $style = '', $otherProperties = '', $helpMessage = '', $autoSort = false, $addToForm = false ) . '
							</td>
						</tr>
						<tr>
							<td align=left>' . $form->createTextBox ( "creditCardNumber", "Card number", ($_POST ['creditCardNumber'] ? $_POST ['creditCardNumber'] : $cNum), $isValueUnique = false, $width = 150, $maxChars = 50, $validator = "required:true;messages:{required:'Card number is required!'}", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'Billing card number is required', $addToForm = false ) . '	</td>
						</tr>
						<tr>
							<td align=left>' . $form->createSimpleComboBox ( "expDateMonth", "Expiration month", $value = $_POST ['expDateMonth'], $width = 50, $arrMonth, $promptText = "", $validator = NULL, $cssClass = '', $style = '', $otherProperties = '', $helpMessage = 'The expiration month of your card', $autoSort = true, $addToForm = false ) . '</td>
							</td>
						</tr>
						<tr>
							<td>' . $form->createSimpleComboBox ( "expDateYear", "Expiration year", $value = $_POST ['expDateYear'], $width = 60, $arrYear, $promptText = "", $validator = NULL, $cssClass = '', $style = '', $otherProperties = '', $helpMessage = 'The expiration year of your card', $autoSort = true, $addToForm = false ) . '</td>
						</tr>
						<tr>
							<td align=left>' . $form->createTextBox ( "cvv2Number", "CVV2 Number", ($_POST ['cvv2Number'] ? $_POST ['cvv2Number'] : $cVV), $isValueUnique = false, $width = 30, $maxChars = 4, $validator = "required:true;messages:{required:'CVV2 number is required!'}", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'The CVV number found at the back of your card', $addToForm = false ) . '</td>
						</tr>
						<tr>
							<td align=left>' . $form->createTextBox ( "address1", "Address 1", ($_POST ['address1'] ? $_POST ['address1'] : $siteMember->getMemberAttribute ( "member_street_address" )), $isValueUnique = false, $width = 320, $maxChars = 255, $validator = "required:true;messages:{required:'Address 1 is required!'}", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'The billing address', $addToForm = false ) . '</td>
						</tr>
						<tr>
	
							<td align=left>' . $form->createTextBox ( "address2", "Address 2", $_POST ['address2'], $isValueUnique = false, $width = 320, $maxChars = 255, $validator = "", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'The billing address 2, Optional', $addToForm = false ) . '</td>
						</tr>
						<tr>
							<td align=left>' . $form->createTextBox ( "city", "City", ($_POST ['city'] ? $_POST ['city'] : $siteMember->getMemberAttribute ( "member_city" )), $isValueUnique = false, $width = 100, $maxChars = 50, $validator = "required:true;messages{required:'Your billing city is required!'}", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'The billing city name', $addToForm = false ) . '</td>
						</tr>
						' . $state . '
						<tr>
							<td align=left>' . $form->createTextBox ( "zip", "Postal code", ($_POST ['zip'] ? $_POST ['zip'] : $siteMember->getMemberAttribute ( "member_zipcode" )), $isValueUnique = false, $width = 80, $maxChars = 6, $validator = "required:true;messages{required:'Your billing postal code is required!'}", $cssClass = '', $style = "", $isPasswordField = false, $hasConfirmPasswordField = false, $otherProperties = '', $helpMessage = 'The billing postal code', $addToForm = false ) . '</td>
						</tr>
						<tr>
							<td align=left>' . $form->createSimpleComboBox ( "country", "Country", $value = $_POST ['country'], $width = 150, $arrCountry, $promptText = "", $validator = NULL, $cssClass = '', $style = '', $otherProperties = '', $helpMessage = 'Billing address country', $autoSort = true, $addToForm = false ) . '</td>
						</tr>
						<tr>
							<td align=right>Amount:' . $amount . ' (' . $currency . ')<input type="hidden" size=4 maxlength=7 name=amount value="' . $amount . '"></td>
						</tr>
						<tr>
							<td align=right>' . $btn . '</td>
						</tr>
					</table>
					</form>
					';
			}
		} else if ($service == "DoExpressCheckout") {
			$this->prepareExpressCheckout ();
			$form = new QFormManager ( 'paypalForm', '', BASESURL . 'order/order-complete/', $method = "", $labelWidth = 150, $style = "", $showFormAfterSubmit = true, $showCallBackMessageInDialog = false, $formBeforeSubmitExtraScript = "", $formAfterSubmitExtraScript = "", $hasMetaDataPanel = false, $metaFormWidth = 180, $metaFormHeight = 400, $target = "_self" );
			$arrButton = array ("btnCheckout" => array ('overImage' => "btn-checkout-hover.gif", 'activeImage' => "btn-checkout-normal.gif", 'disabledImage' => "btn-checkout-disabled.gif", 'isFocus' => false, 'isDisabled' => false, 'complyWithFormReadonly' => true, 'width' => '99', 'height' => '28', 'caption' => "", 'title' => "Checkout", 'jsFunction' => 'doCheckout()', 'link' => '', 'open_link_in_new_window' => '', 'cssClass' => '', 'otherProperties' => '' ) );
			$checkOutJS = '
					doCheckout = function(){
						$("#checkoutButton").hide();
						$.blockUI({ message: $("#wait_dialog_' . $form->formName . '"),' . WAITING_DIALOG_FORMAT . '});
						$("#' . $form->formName . '").submit();
					}
				';
			$componentManager->appendJQueryDocumentReadyStatement ( $checkOutJS );
			$_SESSION ['token'] = $_REQUEST ['token'];
			$_SESSION ['payer_id'] = $_REQUEST ['PayerID'];
			
			$_SESSION ['paymentAmount'] = $_REQUEST ['paymentAmount'];
			$_SESSION ['currCodeType'] = $_REQUEST ['currencyCodeType'];
			$_SESSION ['paymentType'] = $_REQUEST ['paymentType'];
			
			$resArray = $_SESSION ['reshash'];
			
			$form->createHiddenField ( 'doExpressCheckout', 1 );
			$billing_string = '<h1>Billing Information</h1><p>First name: ' . $resArray ['FIRSTNAME'] . '<br/>Last name: ' . $resArray ['LASTNAME'] . '<br/>Address: ' . $resArray ['SHIPTOSTREET'] . '. ' . $resArray ['SHIPTOSTREET2'] . '<br/>City: ' . $resArray ['SHIPTOCITY'] . '<br/>Postal code: ' . $resArray ['SHIPTOZIP'] . '<br/></p>';
			$detailArray = array ("order_billing_firstname" => $resArray ['FIRSTNAME'], "order_billing_lastname" => $resArray ['LASTNAME'], "order_billing_address1" => $resArray ['SHIPTOSTREET'], "order_billing_address2" => $resArray ['SHIPTOSTREET2'], "order_billing_city" => $resArray ['SHIPTOCITY'], "order_billing_state" => $resArray ['SHIPTOSTATE'], "order_billing_zipcode" => $resArray ['SHIPTOZIP'], "order_billing_country" => $resArray ['SHIPTOCOUNTRYCODE'] );
			$order->setPayerDetail ( $detailArray );
			$form->appendHTML ( $billing_string );
			$form->createImageButtonSet ( 'checkoutButton', $arrButton, $showFocus = false, $display = "right", $buttonSpace = 3, $transTime = BUTTON_TRANSITION_TIME, $style = '', $addToForm = true, $embeddedScript = false, $customImageFolder = "" );
			$formString = $form->show ();
		}
		return $formString;
	}
	public function APIError() {
		$resArray = $_SESSION ['reshash'];
		if (isset ( $_SESSION ['curl_error_no'] )) {
			$errorCode = $_SESSION ['curl_error_no'];
			$errorMessage = $_SESSION ['curl_error_msg'];
			unset ( $_SESSION ['curl_error_no'] );
			unset ( $_SESSION ['curl_error_msg'] );
			$ERR_STRING = '<table width="100%">
							<tr>
								<td colspan="2" class="header"><h2>The PayPal API has returned an error!</h2></td>
							</tr>
							<tr>
								<td>Error Number:</td>
								<td>' . $errorCode . '</td>
							</tr>
							<tr>
								<td>Error Message:</td>
								<td>' . $errorMessage . '</td>
							</tr>
						 </table>';
		} else {
			$ERR_STRING = '
					<table width="100%">
						<tr>
							<td colspan="2" class="header"><h2>The PayPal API has returned an error!</h2></td>
						</tr>
						<td>Ack:</td>
						<td>' . $resArray ['ACK'] . '</td>
						</tr>
						<tr>
							<td>Correlation ID:</td>
							<td>' . $resArray ['CORRELATIONID'] . '</td>
						</tr>
						<tr>
							<td>Version:</td>
							<td>' . $resArray ['VERSION'] . '</td>
						</tr>';
			$count = 0;
			while ( isset ( $resArray ["L_SHORTMESSAGE" . $count] ) ) {
				$errorCode = $resArray ["L_ERRORCODE" . $count];
				$shortMessage = $resArray ["L_SHORTMESSAGE" . $count];
				$longMessage = $resArray ["L_LONGMESSAGE" . $count];
				$count = $count + 1;
				$ERR_STRING .= '
						<tr>
							<td>Error Number:</td>
							<td>' . $errorCode . '</td>
						</tr>
						<tr>
							<td>Short Message:</td>
							<td>' . $shortMessage . '</td>
						</tr>
						<tr>
							<td>Long Message:</td>
							<td>' . $longMessage . '</td>
						</tr>';
			}
			$ERR_STRING .= '<tr><td colspan="2">&nbsp;</td></tr><tr><td colspan="2"><em><strong>Please click on Back button on the browser to go back and enter your correct data</strong></em></td></tr></table>';
		}
		return $ERR_STRING;
	}
	public function doDirectPayment() {
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
				$_SESSION ['payment_gateway_message'] = $this->APIError ();
				return false;
			} else {
				$_SESSION ['payment_gateway_message'] = $resArray ["TRANSACTIONID"];
				$_SESSION ['transaction_paid_amount'] = $resArray ['AMT'];
				$_SESSION ['currency_code'] = $resArray ['CURRENCYCODE'];
				return true;
			}
		}
	}
	public function prepareExpressCheckout() {
		require_once SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/CallerService.php';
		require_once SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/constants.php';
		/* An express checkout transaction starts with a token, that
		 identifies to PayPal your transaction
		 In this example, when the script sees a token, the script
		 knows that the buyer has already authorized payment through
		 paypal.  If no token was found, the action is to send the buyer
		 to PayPal to first authorize payment
		 */
		$token = $_REQUEST ['token'];
		if (! isset ( $token )) {
			require_once (SITE_ABSOLUTE_PATH . 'modules/order/classes/site_order.php');
			$order = new QSiteOrder ();
			$paymentAmount = $order->getOrderInfoSession ( "order_total" );
			$currencyCodeType = $order->getOrderInfoSession ( "order_currency" );
			$paymentType = "Sale";
			/* The servername and serverport tells PayPal where the buyer
				should be directed back to after authorizing payment.
				In this case, its the local webserver that is running this script
				Using the servername and serverport, the return URL is the first
				portion of the URL that buyers will return to after authorizing payment
				*/
			$serverName = $_SERVER ['SERVER_NAME'];
			$serverPort = $_SERVER ['SERVER_PORT'];
			$url = dirname ( 'http://' . $serverName . ':' . $serverPort . $_SERVER ['REQUEST_URI'] );
			
			//$paymentAmount=$_REQUEST['paymentAmount'];
			//$currencyCodeType=$_REQUEST['currencyCodeType'];
			//$paymentType=$_REQUEST['paymentType'];
			

			/* The returnURL is the location where buyers return when a
				payment has been succesfully authorized.
				The cancelURL is the location buyers are sent to when they hit the
				cancel button during authorization of payment during the PayPal flow
				*/
			
			$returnURL = urlencode ( BASESURL . 'order/order-review/?currencyCodeType=' . $currencyCodeType . '&paymentType=' . $paymentType . '&paymentAmount=' . $paymentAmount );
			$cancelURL = urlencode ( BASESURL . 'order/payment-method/' );
			
			/* Construct the parameter string that describes the PayPal payment
				the varialbes were set in the web form, and the resulting string
				is stored in $nvpstr
				*/
			
			$nvpstr = "&Amt=" . $paymentAmount . "&PAYMENTACTION=" . $paymentType . "&ReturnUrl=" . $returnURL . "&CANCELURL=" . $cancelURL . "&CURRENCYCODE=" . $currencyCodeType . "&ORDERDESC=" . $_SESSION ['order_description'];
			
			/* Make the call to PayPal to set the Express Checkout token
				If the API call succeded, then redirect the buyer to PayPal
				to begin to authorize payment.  If an error occured, show the
				resulting errors
				*/
			$resArray = hash_call ( "SetExpressCheckout", $nvpstr );
			$_SESSION ['reshash'] = $resArray;
			
			$ack = strtoupper ( $resArray ["ACK"] );
			
			if ($ack == "SUCCESS") {
				// Redirect to paypal.com here
				$token = urldecode ( $resArray ["TOKEN"] );
				$payPalURL = PAYPAL_URL . $token;
				header ( "Location: " . $payPalURL );
			} else {
				//Redirecting to APIError.php to display errors.
				echo $_SESSION ['payment_gateway_message'] = $this->APIError ();
				return false;
			}
		} else {
			/* At this point, the buyer has completed in authorizing payment
				at PayPal.  The script will now call PayPal with the details
				of the authorization, incuding any shipping information of the
				buyer.  Remember, the authorization is not a completed transaction
				at this state - the buyer still needs an additional step to finalize
				the transaction
				*/
			
			$token = urlencode ( $_REQUEST ['token'] );
			
			/* Build a second API request to PayPal, using the token as the
				ID to get the details on the payment authorization
				*/
			$nvpstr = "&TOKEN=" . $token;
			
			/* Make the API call and store the results in an array.  If the
				call was a success, show the authorization details, and provide
				an action to complete the payment.  If failed, show the error
				*/
			$resArray = hash_call ( "GetExpressCheckoutDetails", $nvpstr );
			$_SESSION ['reshash'] = $resArray;
			$ack = strtoupper ( $resArray ["ACK"] );
			
			if ($ack != "SUCCESS") {
				$_SESSION ['reshash'] = $resArray;
				echo $_SESSION ['payment_gateway_message'] = $this->APIError ();
				return false;
			}
		}
	}
	public function doExpressCheckout() {
		require_once SITE_ABSOLUTE_PATH . 'library/core/transaction/method/paypal/CallerService.php';
		
		/* Gather the information to make the final call to
			finalize the PayPal payment.  The variable nvpstr
			holds the name value pairs
			*/
		
		$token = urlencode ( $_SESSION ['token'] );
		$paymentAmount = urlencode ( $_SESSION ['paymentAmount'] );
		$paymentType = urlencode ( $_SESSION ['paymentType'] );
		$currCodeType = urlencode ( $_SESSION ['currCodeType'] );
		$payerID = urlencode ( $_SESSION ['payer_id'] );
		$serverName = urlencode ( $_SERVER ['SERVER_NAME'] );
		
		$nvpstr = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTACTION=' . $paymentType . '&AMT=' . $paymentAmount . '&CURRENCYCODE=' . $currCodeType . '&IPADDRESS=' . $serverName;
		
		/* Make the call to PayPal to finalize payment
			If an error occured, show the resulting errors
			*/
		$resArray = hash_call ( "DoExpressCheckoutPayment", $nvpstr );
		
		/* Display the API response back to the browser.
			If the response from PayPal was a success, display the response parameters'
			If the response was an error, display the errors received using APIError.php.
			*/
		$ack = strtoupper ( $resArray ["ACK"] );
		if ($ack != "SUCCESS") {
			$_SESSION ['reshash'] = $resArray;
			$_SESSION ['payment_gateway_message'] = $this->APIError ();
			return false;
		} else {
			$_SESSION ['payment_gateway_message'] = $resArray ["TRANSACTIONID"];
			$_SESSION ['transaction_paid_amount'] = $resArray ['AMT'];
			$_SESSION ['currency_code'] = $resArray ['CURRENCYCODE'];
			return true;
		}
	}
}
?>
