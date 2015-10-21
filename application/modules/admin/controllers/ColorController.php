<?php
class Admin_ColorController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['car_paint_color'] ))
			$error [] = 'Bạn chưa nhập màu sắc xe';					
		return $error;
	}
	public function indexAction(){
		$this->view->Title = "Phong thủy xe";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Color ) = Color::getAll ($condition,$page);
	}
	public function createAction(){
		$this->view->Title = "Phong thủy xe";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {			
			$request = $this->getRequest ()->getParams ();			
			$error = $this->_checkForm ( $request );
			$Product = new Color();
			$Product->merge ( $request );
			if($Product->trySave()){
				$folder = $Product->id;
			}			
			if($_FILES['image']['name']){
					$dirname = "uploads/color/".$folder."/";										
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['image'],800,600,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;						
					}									
				}			
			if (count ( $error ) == 0) {				
				if($filename != ""){
				$Product->image = 	$filename;
				}											
				$Product->save ();
				$this->Member->log ( 'Phong thủy xe:' . $Product->car_paint_color . '(' . $Product->id . ')', 'Tạo mới' );
				My_Plugin_Libs::setSplash ( 'Phong thủy xe: <b>' . $Product->car_paint_color . '</b> đã tạo thành công. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'color', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Phong thủy xe";
		$this->view->headTitle ( $this->view->Title );
		$Product = Color::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform
			$error = $this->_checkForm ( $request );			
			if($_FILES['image']['name']){					
					$dir = new My_Plugin_Libs();
					$name = $dir->trimSpacer($request['car_paint_color']);
					$dirname = "uploads/color/".$Product->id."/";										
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['image'],800,600,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;						
					}									
				}
			if (count ( $error ) == 0) {
				$Product->merge ( $request );
				if($filename != ""){
				$Product->image = 	$filename;
				}
				$Product->save();
				$this->Member->log ( 'Phong thủy xe:' . $Product->car_paint_color . '(' . $Product->id  . ')', 'Sửa chữa' );
				My_Plugin_Libs::setSplash ( 'Phong thủy xe: <b>' . $Product->car_paint_color . '</b> đã sửa thành công. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'color', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Color = $Product;
	}
	
	public function deleteAction() {
		$Product = Color::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Product) {
			if ($this->getRequest ()->isPost ()) {
				$dir = new My_Plugin_Libs();
				$name = $dir->trimSpacer($request['car_paint_color']);
				$dirname = "uploads/color/".$name."/".$Product->image;										
				if(is_file($dirname)){
					@chmod($dirname,0666);
					@unlink($dirname);	
				}
				$Product->delete ();						
				$this->Member->log ( 'Phong thủy xe: ' . $Product->car_paint_color . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Xóa' );
				My_Plugin_Libs::setSplash('Phong thủy xe: <b>'.$Product->car_paint_color.'</b> đã được xóa khỏi hệ thống.');
				$this->_redirect ( $this->_helper->url ( 'index', 'color', 'admin' ) );
			}
			$this->view->Color = $Product;
		}
	}
}