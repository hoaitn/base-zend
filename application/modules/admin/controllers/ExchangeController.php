<?php
class Admin_ExchangeController extends Zend_Controller_Action {
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}
	/**
	 * List Countries
	 */
	public function indexAction() {
		$this->view->Title = "Quản lý link";
		$this->view->headTitle ( $this->view->Title );		
		$condition = array ();
		if ($this->getRequest ()->getParam ( 'keyword' ))
			$condition ['name LIKE ?'] = "%{$this->getRequest ()->getParam ( 'keyword' )}%";
		list ( $this->view->Paper, $this->view->ExchangeLinks ) = ExchangeLinks::getAll ( $condition );
	}
	/**
	 * Create Hotel Type
	 */
	public function createAction() {
		$this->view->Title = "Thêm mới exchange link";
		$this->view->headTitle ( $this->view->Title );
		//Sử lý khi có yêu cầu tạo mới group		
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();
			$Exchange = new ExchangeLinks ();
			$Exchange->merge ( $request );
			$Exchange->save ();
			$this->Member->log ( 'Create link exchange :' . $Exchange->name . '(' . $Exchange->id . ')', 'Exchange' );
			My_Plugin_Libs::setSplash ( 'Exchange: <b>' . $Exchange->name . '</b> đã được tạo. ' );
			$this->_redirect ( $this->_helper->url ( 'index', 'exchange', 'admin' ) );
		}
		$this->view->Create = $Exchange;
	}
	/**
	 * Edit Hotel Type via Ajax
	 */
	public function editAction() {
		$this->view->Title = "Sửa exchange link";
		$this->view->headTitle ( $this->view->Title );
		$Exchange = ExchangeLinks::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$Exchange->merge ( $_POST );
			echo ($Exchange->save ());
			$this->Member->log ( 'Edit link exchange :' . $Exchange->name . '(' . $Exchange->id . ')', 'Exchange' );
			My_Plugin_Libs::setSplash ( 'Exchange: <b>' . $Exchange->name . '</b> đã được sủa. ' );
			$this->_redirect ( $this->_helper->url ( 'index', 'exchange', 'admin' ) );
		} 
		$this->view->Edit = $Exchange;
	}
	/**
	 * Delete a Hotel Type
	 */
	public function deleteAction() {
		$Exchange = ExchangeLinks::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Exchange) {
			if ($this->getRequest ()->isPost ()) {
				$Exchange->delete ();
				$this->Member->log ( 'Delete link exchange :' . $Exchange->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Exchange' );
				$this->_redirect ( $this->_helper->url ( 'index', 'exchange', 'admin' ) );
			}
			$this->view->ExchangeLinks = $Exchange;
		}
	}
	//list category
	public function categoryAction() {
		$this->view->Title = "Quản lý nhóm link";
		$this->view->headTitle ( $this->view->Title );		
		$condition = array ();
		if ($this->getRequest ()->getParam ( 'keyword' ))
			$condition ['name LIKE ?'] = "%{$this->getRequest ()->getParam ( 'keyword' )}%";
		$this->view->ExchangeCategories = ExchangeCategories::getAll ( $condition );
	}
	//create category
	public function createcategoryAction() {
		$this->view->Title = "Thêm mới nhóm link";
		$this->view->headTitle ( $this->view->Title );
		//Sử lý khi có yêu cầu tạo mới group		
		if ($this->getRequest ()->isPost ()) {
			$ExchangeCategories = new ExchangeCategories ();
			$ExchangeCategories->merge ( $this->getRequest ()->getParams () );
			$ExchangeCategories->save ();
			$this->Member->log ( 'Create exchange categories:' . $ExchangeCategories->name . '(' . $ExchangeCategories->id . ')', 'Exchange' );
			My_Plugin_Libs::setSplash ( 'Exchange categories: <b>' . $ExchangeCategories->name . '</b> đã được tạo. ' );
			$this->_redirect ( $this->_helper->url ( 'category', 'exchange', 'admin' ) );
		}
		$this->view->create = $ExchangeCategories;
	}
	//edit category
	public function editcategoryAction() {
		$this->view->Title = "Sửa nhóm link";
		$this->view->headTitle ( $this->view->Title );
		$ExchangeCategories = ExchangeCategories::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$ExchangeCategories->merge ( $_POST );
			echo ($ExchangeCategories->save ());
			$this->Member->log ( 'Create exchange categories:' . $ExchangeCategories->name . '(' . $ExchangeCategories->id . ')', 'Exchange' );
			My_Plugin_Libs::setSplash ( 'Exchange categories: <b>' . $ExchangeCategories->name . '</b> đã được sửa. ' );
			$this->_redirect ( $this->_helper->url ( 'category', 'exchange', 'admin' ) );
		} 
		$this->view->edit = $ExchangeCategories; 
	}
	//delete category
	public function deletecategoryAction() {
		$ExchangeCategories = ExchangeCategories::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($ExchangeCategories) {
			if ($this->getRequest ()->isPost ()) {
				$ExchangeCategories->delete ();
				$this->Member->log ( 'Delete exchange categories :' . $ExchangeCategories->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Exchange' );
				$this->_redirect ( $this->_helper->url ( 'category', 'exchange', 'admin' ) );
			}
			$this->view->ExchangeCategories = $ExchangeCategories;
		}
	}
}