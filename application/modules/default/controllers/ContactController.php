<?php
class ContactController extends Zend_Controller_Action {
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['full_name'] ))
			$error [] = 'Bạn chưa nhập tên!';		
		if (empty ( $form ['email'] ))
			$error [] = 'Bạn chưa nhập email!';		
		if (empty ( $form ['phone'] ))
			$error [] = 'Bạn chưa nhập số điện thoại!';
		if (empty ( $form ['address'] ))
			$error [] = 'Bạn chưa nhập địa chỉ!';			
		$validator = new My_Plugin_Captcha($captchaID);			
		if(!$validator->isValid($form['captcha'])){
				   $message = $validator->getMessages();
				   $error [] = current($message);				   
		}	
		return $error;
	}
	public function indexAction() {
		$this->view->Title = 'Đặt hàng';
		$this->view->headTitle ( $this->view->Title );	
		$id =  $this->getRequest ()->getParam ("id_product");
		$Product = Product::getById($id);
		if ($this->getRequest ()->isPost ()) {			
			$request = $this->getRequest ()->getParams ();		    									
			$error = $this->_checkForm ( $request );
				if (count ( $error ) == 0) {
					$Contact = new Contact ();
					$Contact->merge ( $request );
					$Contact->created_date = date("Y-m-d H:i:s");				
					$Contact->save ();
					//$_SESSION['msg'] = "Yêu cầu đặt hàng của bạn đã được gửi, xin trân thành cảm ơn!";
					My_Plugin_Libs::setSplash ( '<b>Yêu cầu đặt hàng của bạn đã được gửi, xin trân thành cảm ơn!</b>' );
					$this->_redirect ( $this->_helper->url ( 'index', 'contact', 'default' ) );
				}
			if (count ( $error )) {
				$this->view->error = $error;
			}	
		
		}
		$this->view->Product = $Product;
		$this->view->Contact = $Contact;		
	}
}