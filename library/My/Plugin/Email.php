<?php

class My_Plugin_Email extends Zend_Controller_Plugin_Abstract {
	
	public function __construct() {
		$tr = new Zend_Mail_Transport_Smtp ( Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_HOST, array ('auth' => 'login', 'username' => Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_USER, 'password' => Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_PASS, 'port' => Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_PORT ) );
		if (Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_SSL)
			array ('ssl' => Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_SSL );
		Zend_Mail::setDefaultTransport ( $tr );
		Zend_Mail::setDefaultFrom ( Zend_Registry::get ( 'Setting' )->webmaster_email, Zend_Registry::get ( 'Setting' )->webmaster_name );
		Zend_Mail::setDefaultReplyTo ( Zend_Registry::get ( 'Setting' )->webmaster_email, Zend_Registry::get ( 'Setting' )->webmaster_name );
	}
	private function _send($subject, $email, $name, $message) {
		$oEmail = new My_Plugin_Email ();
		$oEmail->send ( $subject, $email, $name, $message );
	}
	/**
	 * Gửi Email đến 1 địa chỉ nào đó
	 * @param string $subject Tiêu đề Email
	 * @param string $email Email người nhận
	 * @param string $name Tên người nhận
	 * @param string $message Nội dung Email
	 * @param string $type kiểu dữ liệu gửi đi html|text
	 */
	public function send($subject, $email, $name, $message, $type = 'html') {
		$mail = new Zend_Mail ( 'utf-8' );
		if ($type == 'html')
			$mail->setBodyHtml ( $message );
		else
			$mail->setBodyText ( $message );
		$mail->addTo ( $email, $name );
		$mail->setSubject ( $subject );
		$mail->send ();
	}
	/**
	 * Tạo Object Layout cho Email
	 */
	private function generateLayout() {
		$layout = new Zend_Layout ();
		$layout->setLayoutPath ( APPLICATION_PATH . 'modules/admin/views/scripts/email' );
		$layout->setLayout ( 'layout' );
		return $layout;
	}
	/**
	 * Tạo Object View cho Email
	 */
	private function generateView() {
		$view = new Zend_View ();
		$view->setScriptPath ( APPLICATION_PATH . 'modules/admin/views/scripts/email' );
		return $view;
	}
	/**
	 * Gửi Email xác nhận đặt phòng cho khách hàng
	 * @param string $email
	 * @param string $name
	 * @param string $password Nếu là account mới thì sẽ cần password
	 * @param Object $Booking
	 */
	public static function sendBookingConfirmation($email, $name, $password, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		if ($password != '')
			$view->assign ( 'password', $password );
		$layout->content = $view->render ( 'confirmbooking.phtml' );
		$subject = 'Confirmation for Hotel Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
	/**
	 * Gửi thông tin Credit card đến Email của kế toán
	 * @param Object $Booking
	 */
	public static function sendBookingCreditCard($Booking) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'creditcard.phtml' );
		$oEmail = new My_Plugin_Email ();
		$oEmail->send ( $Booking->getBookingId () . ' Thông tin thẻ Credit card', Zend_Registry::get ( 'Setting' )->account_email, 'TUN Travel Accountant', $layout->render () );
	}
	/**
	 * Gửi Email Invoice cho khách hàng
	 * @param string $email
	 * @param string $name
	 * @param Object $Booking
	 */
	public static function sendBookingInvoice($email, $name, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'billconfirmation.phtml' );
		$subject = 'Receipt/Tax Invoice for Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
	/**
	 * Gửi Email xác nhận trạng thái Amen của Booking cho khách hàng
	 * @param string $email
	 * @param string $name
	 * @param object $Booking
	 */
	public static function sendBookingAmen($email, $name, $Booking) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'amen_cancel_request.phtml' );
		$oEmail = new My_Plugin_Email ();
		$oEmail->send ( 'Amend Request for Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity (), $email, $name, $layout->render () );
	}
	/**
	 * Gửi Email xác nhận Amen thành công cho khách hàng
	 * @param string $email
	 * @param string $name
	 * @param object $Booking
	 */
	public static function sendBookingAmenConfirm($email, $name, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'amen.phtml' );
		
		$subject = 'Amen Confirmation for Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
	/**
	 * Gửi Email xác nhận yêu cầu Cancel của khách hàng
	 * @param $email
	 * @param $name
	 * @param $Booking
	 */
	public static function sendBookingCancel($email, $name, $Booking) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'amen_cancel_request.phtml' );
		$oEmail = new My_Plugin_Email ();
		$oEmail->send ( 'Cancel Request for Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity (), $email, $name, $layout->render () );
	}
	/**
	 * Gửi Email xác nhận trạng thái Cancel thành công hoặc Cancel booking từ Saler tới khách hàng
	 * @param unknown_type $email
	 * @param unknown_type $name
	 * @param unknown_type $Booking
	 */
	public static function sendBookingCancelConfirm($email, $name, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'amen.phtml' );
		
		$subject = 'Cancel Confirmation for Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
	/**
	 * Send Email yêu cầu thanh toán
	 * @param $email
	 * @param $name
	 * @param $Booking
	 */
	public static function sendBookingPaymentRequest($email, $name, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'paymentrequest.phtml' );
		
		$subject = 'Payment for Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
	public static function sendBookingNoShow($email, $name, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'noshow.phtml' );
		
		$subject = 'No-show for Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
	public static function sendBookingFull($email, $name, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'full.phtml' );
		
		$subject = 'Fully Booked for ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
	public static function sendBookingVoucher($email, $name, $Booking, $return = false) {
		$layout = self::generateLayout ();
		$view = self::generateView ();
		$view->assign ( 'Booking', $Booking );
		$layout->content = $view->render ( 'voucher.phtml' );
		
		$subject = 'Online Booking Voucher Booking ID ' . $Booking->getBookingId () . ' at ' . $Booking->getHotel () . ', ' . $Booking->getHotelCity ();
		$content = $layout->render ();
		if ($return) {
			return array ($subject, $content );
		} else
			self::_send ( $subject, $email, $name, $content );
	}
}
