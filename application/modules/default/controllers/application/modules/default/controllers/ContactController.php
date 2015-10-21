<?php
class ContactController extends Zend_Controller_Action {
	private function _checkForm($form) {
		$captcha = new My_Plugin_Image();
		$captchaID = $form['captchaID'];
		$captcha->removeImg($captchaID);
		
		$error = array ();
		if (empty ( $form ['contact_first_name'] ))
			$error [] = 'First Name is required!';		
		if (empty ( $form ['contact_last_name'] ))
			$error [] = 'Last Name is required!';		
		if (empty ( $form ['contact_email'] ))
			$error [] = 'Email is required!';
		if (empty ( $form ['contact_phone'] ))
			$error [] = 'Phone number is required!';
		if (empty ( $form ['message'] ))
			$error [] = 'Message is required!';	
		$validator = new My_Plugin_Captcha($captchaID);			
		if(!$validator->isValid($form['captcha'])){
				   $message = $validator->getMessages();
				   $error [] = current($message);				   
		}	
		return $error;
	}
	public function indexAction() {
		$this->view->Title = 'Contact form';
		$this->view->headTitle ( $this->view->Title );					
        $captcha = new My_Plugin_Image();
 	    $this->view->captcha = $captcha->render($this->view);
 	    $this->view->captcha_id = $captcha->getId(); 
			 
		if ($this->getRequest ()->isPost ()) {			
			$request = $this->getRequest ()->getParams ();		    									
			$error = $this->_checkForm ( $request );
				if (count ( $error ) == 0) {
					$Contact = new Contact ();
					$Contact->merge ( $request );				
					$Contact->save ();
					/**
					 * Check server mail valid
					 * @var unknown_type
					 */
					$check_mail_server = array ('username' => Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_USER, 'password' => Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_PASS, 'port' => Zend_Registry::get ( 'Setting' )->EMAIL_SMTP_PORT );
					
					if(!$check_mail_server['username'] || !$check_mail_server['password'] || !$check_mail_server['port']){						
						/**
						 * Not send mail to admin
						 */
						My_Plugin_Libs::setSplash ( '<b>Your feedback have been send to us. Thank you very much!</b>' );
						$this->_redirect ( $this->_helper->url ( 'index', 'contact', 'default' ) );
					}else{
						/**
						 * Send mail to admin
						 */
						if($request['contact_type'] == "Contact"){
							$subject = "[".Zend_Registry::get('Setting')->DOMAIN."][Contact] From : ".$request['contact_first_name']." ".$request['contact_last_name'];
						}else{
							$subject = "[".Zend_Registry::get('Setting')->DOMAIN."][Get listed] - From: ".$request['contact_first_name']." ".$request['contact_last_name'];
						}
						$email = Zend_Registry::get('Setting')->webmaster_email;
						$name = "Administrator";
						$message = $request['message'];					
						$sendmail = new My_Plugin_Email();
						$sendmail->send($subject, $email, $name, $message, $type = 'html');					
						My_Plugin_Libs::setSplash ( '<b>Your feedback have been send to us. Thank you very much!</b>' );
						$this->_redirect ( $this->_helper->url ( 'index', 'contact', 'default' ) );
					}
				}
			if (count ( $error )) {
				$this->view->error = $error;
			}	
		
		}
		$this->view->Contact = $Contact;		
	}
}