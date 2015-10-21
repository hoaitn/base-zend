<?php
class ProductController extends Zend_Controller_Action{
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['textSearch'] ))
			$error [] = 'You must be enter a keyword to search!';				
		return $error;
	}
	public function indexAction() {		
		$group = $this->getRequest()->getParam('product_group');			
		$Product = Product::getByGroupId($group);
		$Group = ProductGroup::getById($group);
		$this->view->Product = $Product;
		$this->view->Title = $Group->name;
		$this->view->headTitle ( $this->view->Title );
	}
	public function detailsAction(){
		$id = $this->getRequest()->getParam("product_id");
		$Product = Product::getById($id);			
		$this->view->Product = $Product;
		$this->view->Title = $Product->product_name;
		$this->view->headTitle ( $this->view->Title );
	}
	public function otherAction(){
		
	}
}