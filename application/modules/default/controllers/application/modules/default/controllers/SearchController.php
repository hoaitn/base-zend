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
					$condition = array ();
					$condition['firstName LIKE ?'] = "%{$request ['textSearch']}%";
					$condition['lastName LIKE ?'] = "%{$request ['textSearch']}%";
					$condition['city LIKE ?'] = "%{$request ['textSearch']}%";
					$session_condition = array();
					$session_condition['textSearch'] = $request ['textSearch'];
					$_SESSION['Condition'] = $session_condition;
					$page = $this->getRequest()->getParam('page');
					list($this->view->Pager,$this->view->Trainer)= Trainer::getAllBySearch($condition,$page,50,$order = 'lastName,firstName');							
					$this->view->Title = "Search Trainers by keyword: <span style='color:#0073EA'>".$request ['textSearch']."</span>";
					$this->view->headTitle ( $this->view->Title );
				}
			}else{
				$this->view->error = $error;
			}
		}else{			
			if($_SESSION['Condition'] != ""){			
			$condition = array ();
			$condition['firstName LIKE ?'] = "%{$_SESSION['Condition']['textSearch']}%";
			$condition['lastName LIKE ?'] = "%{$_SESSION['Condition']['textSearch']}%";
			$condition['city LIKE ?'] = "%{$_SESSION['Condition']['textSearch']}%";			
			$page = $this->getRequest()->getParam('page');	
			list($this->view->Pager,$this->view->Trainer)= Trainer::getAllBySearch($condition,$page,50,$order = 'firstName, lastName');
			$this->view->Title = "Search Trainers by keyword: <span style='color:#0073EA'>".$_SESSION['Condition']['textSearch']."</span>";
			$this->view->headTitle ( $this->view->Title );
			}else{
			$error[] = "Not found data. Please enter a keyword to search!";
			$this->view->error = $error;
			}
		}
	}
}