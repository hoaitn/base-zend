<?php
class ContentController extends Zend_Controller_Action {
	public function indexAction() {
		$name_plain = $this->getRequest ()->getParam ( 'name_plain' );			
		$Content = Content::getByName ( $name_plain );
		if ($Content) {
			$this->view->Title = $Content->content_title;
			$this->view->headTitle ( $this->view->Title );
			$this->view->Content = $Content;			
			$this->view->headMeta ()->appendName ( 'description', $Content->content_description )->appendName ( 'keywords', $Content->content_keyword );
		}
	}
	public function headerAction(){
		
	}
}