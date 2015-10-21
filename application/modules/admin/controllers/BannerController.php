<?php
class Admin_BannerController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];		
	}
	
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['title'] ))
			$error [] = 'Bạn chưa nhập tiêu đề tin tức!';
		if (empty ( $form ['content'] ))
			$error [] = 'Nội dung tin tức không được bỏ trống!';					
		return $error;
	}
	public function indexAction() {
		$this->view->Title = "Quản lý quảng cáo";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Banner ) = Banner::getAll ($condition,$page);
	}
	public function createAction() {
		$this->view->Title = "Quản lý quảng cáo";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();	
			$Banner = new Banner ();
			$Banner->merge ( $request );
			if($Banner->trySave()){
				$folder = $Banner->id;
			}
			if($_FILES['images']['name']){					
					$dirname = "uploads/banner/".$folder."/";										
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['images'],2048,1024,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;						
					}									
				}
			if (count ( $error ) == 0) {				
				if($filename != ""){
				$Banner->image = $filename;
				}				
				$Banner->save ();
				$this->Member->log ( 'Quảng cáo:' . $Banner->name . '(' . $Banner->id . ')', 'Tạo mới' );
				My_Plugin_Libs::setSplash ( 'Quảng cáo: <b>' . $Banner->name . '</b> đã tạo thành công. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'banner', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Quản lý quảng cáo";
		$this->view->headTitle ( $this->view->Title );
		$Banner = Banner::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform			
			if($_FILES['images']['name']){				
					$dir = new My_Plugin_Libs();
					$name = $dir->trimSpacer($request['title']);
					$dirname = "uploads/banner/".$Banner->id."/";										
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['images'],2048,1024,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;						
					}									
				}
			if (count ( $error ) == 0) {
				$Banner->merge ( $request );
				if($filename != ""){
				$Banner->image = $filename;
				}				
				$Banner->save();
				$this->Member->log ( 'Quảng cáo:' . $Banner->name . '(' . $Banner->id  . ')', 'Sửa chữa' );
				My_Plugin_Libs::setSplash ( 'Quảng cáo: <b>' . $Banner->name . '</b> đã sửa thành công. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'banner', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Banner = $Banner;
	}
	/**
	 * Delete a Country
	 */
	public function deleteAction() {
		$Banner = Banner::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Banner) {
			if ($this->getRequest ()->isPost ()) {
				$Banner->delete ();				
				$this->Member->log ( 'Quảng cáo: ' . $Banner->name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa' );
				My_Plugin_Libs::setSplash('Quảng cáo: <b>'.$Banner->name.'</b> đã được xóa khỏi hệ thống.');
				$this->_redirect ( $this->_helper->url ( 'index', 'banner', 'admin' ) );
			}
			$this->view->Banner = $Banner;
		}
	}
}