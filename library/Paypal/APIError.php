<?php
/*************************************************
 APIError.php

 Displays error parameters.

 Called by DoDirectPaymentReceipt.php, TransactionDetails.php,
 GetExpressCheckoutDetails.php and DoExpressCheckoutPayment.php.

 *************************************************/
$resArray = $_SESSION ['reshash'];
if (isset ( $_SESSION ['curl_error_no'] )) {
	$errorCode = $_SESSION ['curl_error_no'];
	$errorMessage = $_SESSION ['curl_error_msg'];
	unset ( $_SESSION ['curl_error_no'] );
	unset ( $_SESSION ['curl_error_msg'] );
	$ERR_STRING = '<table width="100%">
				<tr>
					<td colspan="2" class="header">The PayPal API has returned an error!</td>
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
				<td colspan="2" class="header">The PayPal API has returned an error!</td>
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
			</tr>
			</table>';
	}
}