<?php
class SearchController extends Zend_Controller_Action {
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['textSearch'] ))
			$error [] = 'You must be enter a keyword to search!';				
		return $error;
	}
	public function indexAction() {		
		$error = array();
		if ($this->getRequest ()->isPost ()) {			
			$request = $this->getRequest ()->getParams ();						
			$error = $this->_checkForm($request);
			if(count($error) == 0){
				if ($request ['textSearch']) {					
					$condition = "%{$request ['textSearch']}%";						
					$page = $this->getRequest()->getParam('page');
					$this->view->Search = Product::getSearchProduct($condition,$order = 'id DESC',$request ['id_group_product']);					
					$this->view->Title = "Tìm kiếm";
					$this->view->headTitle ( $this->view->Title );
				}
			}else{
				$this->view->error = $error;
			}
		}
	}
}