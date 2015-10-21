<?php
class My_Plugin_Image extends Zend_Captcha_Image{
	
	public function __construct(){

		
		$this->setImgDir(realpath(CAPTCHA_PATH . '/images/captcha'));
		$path = realpath(CAPTCHA_URL . '/images/captcha');
		
		$this->setImgUrl(realpath(CAPTCHA_URL . '/images/captcha'));		
		
		$this->setWordlen(6);		
		
		$this->setFont(realpath(CAPTCHA_PATH . '/font/ARIAL.TTF'));		
		
		$this->setFontSize(30);		
		
		$this->setWidth(180);
		$this->setHeight(70);
		$this->setTimeout(300);
		
		$this->generate();
		
		$thisSession = new Zend_Session_Namespace('Zend_Form_Captcha_' . $this->getId());
		$thisSession->word = $this->getWord();
	}
	
	public function removeImg($captcha_id){
		$file  = CAPTCHA_PATH . '/images/captcha/' . $captcha_id . $this->getSuffix();
		@unlink($file);
	}
} 
