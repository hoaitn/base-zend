<?php
class Admin_VideoController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];		
	}
	
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['name'] ))
			$error [] = 'Bạn chưa nhập tiêu đề video!';
		if (empty ( $form ['link'] ))
			$error [] = 'Bạn chưa nhập đường dẫn video!';					
		return $error;
	}
	public function indexAction() {
		$this->view->Title = "Manage Video";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Video ) = Video::getAll ($condition,$page);
	}
	public function createAction() {
		$this->view->Title = "Manage Video";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();	
			$error = $this->_checkForm($request);
			if (count ( $error ) == 0) {				
				$Video = new Video ();
				$Video->merge ( $request );				
				$Video->save ();
				$this->Member->log ( 'Video:' . $Video->name . '(' . $Video->id . ')', 'Tạo mới' );
				My_Plugin_Libs::setSplash ( 'Video: <b>' . $Video->name . '</b> đã tạo thành công. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'video', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Manage Video";
		$this->view->headTitle ( $this->view->Title );
		$Video = Video::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform			
			$error = $this->_checkForm($request);
			if (count ( $error ) == 0) {
				$Video->merge ( $request );								
				$Video->save();
				$this->Member->log ( 'Video:' . $Video->name . '(' . $Video->id  . ')', 'Sửa chữa' );
				My_Plugin_Libs::setSplash ( 'Video: <b>' . $Video->name . '</b> đã sửa thành công. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'video', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Video = $Video;
	}
	/**
	 * Delete a Country
	 */
	public function deleteAction() {
		$Video = Video::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Video) {
			if ($this->getRequest ()->isPost ()) {
				$Video->delete ();				
				$this->Member->log ( 'Video: ' . $Video->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa' );
				My_Plugin_Libs::setSplash('Video: <b>'.$Video->name.'</b> đã được xóa khỏi hệ thống.');
				$this->_redirect ( $this->_helper->url ( 'index', 'video', 'admin' ) );
			}
			$this->view->Video = $Video;
		}
	}
}