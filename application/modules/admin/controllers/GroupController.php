<?php

class Admin_GroupController extends Zend_Controller_Action {
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
        $ss = new Zend_Session_Namespace('member');
		$this->Member = $ss->__get('Member');        
	}
    	
	public function indexAction() {
		$this->view->Title = "Management member group";
		$this->view->headTitle ( $this->view->Title );
		//Assign create form		
		$condition = array ();
		if ($this->getRequest ()->getParam ( 'keyword' ))
			$condition ['name LIKE ?'] = "%{$this->getRequest ()->getParam ( 'keyword' )}%";
		$this->view->Group = Groups::getAll ( $condition );
	}	
	public function createAction() {
		$this->view->Title = "Management member group";
		$this->view->headTitle ( $this->view->Title );
		
		if ($this->getRequest ()->isPost ()) {
			$Group = new Groups ();
			$Role = $this->getRequest ()->getParam ( 'Role' );
			$Group->merge ( $_POST );
			$Group->role = Zend_Json::encode ( $Role );
			$Group->save ();
			$this->Member->log ( 'Member group: ' . $Group->name . ' (' . $Group->id . ')','Create' );
			My_Plugin_Libs::setSplash ( 'Create:<b>' . $Group->name . '</b> have been completed.' );
			
			$this->_redirect ( $this->_helper->url ( 'index', 'Group' ) );
		}
		$Resources = new Zend_Config_Xml ( APPLICATION_PATH . '/configs/resources.xml', 'admin' );
		$this->view->Resources = $Resources;
	}
	public function editAction() {
		$this->view->Title = "Management member group";
		$this->view->headTitle ( $this->view->Title );
		$Group = Groups::getById ( $this->getRequest ()->getParam ( 'id' ) );
		$Resources = new Zend_Config_Xml ( APPLICATION_PATH . '/configs/resources.xml', 'admin' );
		if ($this->getRequest ()->isPost ()) {
			$Role = $this->getRequest ()->getParam ( 'Role' );
			$Group->merge ( $_POST );
			$Group->role = Zend_Json::encode ( $Role );
			$Group->save ();
			$this->Member->log ( 'Member group: ' . $Group->name . ' (' . $Group->id . ')', 'Edit' );
			My_Plugin_Libs::setSplash ( 'Edite:<b>' . $Group->name . '</b> have been completed.' );
			$this->_redirect ( $this->_helper->url ( 'index', 'Group' ) );
		}
		$this->view->Resources = $Resources;
		$Group->role = Zend_Json::decode ( $Group->role );
		$this->view->Group = $Group;
	
	}	
	public function deleteAction() {
		$Group = Groups::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Group) {
			if ($this->getRequest ()->isPost ()) {				
				$Group->delete ();
				My_Plugin_Libs::setSplash ( 'Delete:<b>' . $Group->name . '</b> have been completed.' );				
				$this->Member->log ( 'Member group:' . $Group->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Delete' );
				$this->_redirect ( $this->_helper->url ( 'index', 'Group', 'admin' ) );
			}
			$this->view->Group = $Group;
		}
	}
}

