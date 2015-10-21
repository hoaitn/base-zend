<?php
class Admin_ProductController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];
	}
	private function _checkForm($form) {
		$error = array ();
		if (empty ( $form ['product_name'] ))
			$error [] = 'Product name is required!';
		if ( empty ($form ['product_details']))		
			$error [] = 'Product details is required!';	
		if (empty ( $form ['product_price'] ))
			$error [] = 'Product price is required!';
		if (empty ( $form ['manufacturer'] ))
			$error [] = 'Manufacturer is required!';
	  	if (empty ( $form ['warranty'] ))
			$error [] = 'Warranty is required!';			
		return $error;
	}
	private function _uploadLogo($uploadDir = '') {
		//print_r($uploadDir);die();
		if (! is_dir( $uploadDir )) {
			@mkdir( $uploadDir );
			chmod( $uploadDir, 0777 );
		}		
		//upload thumb image
		$image = new Zend_Form_Element_File( 'logo_hotel' );
		$image->setDestination( $uploadDir );
		$image->addValidator( 'Count', false, 1 );
		$image->addValidator( 'Extension', false, 'jpeg,jpg,png,gif' );
		$image->addFilter( 'Rename', array ('target' => $uploadDir . DIRECTORY_SEPARATOR . 'logo.jpg', 'overwrite' => true ) );
		$image->receive();
	}
	private function _uploadFiles($uploadDir = '') {		
		if (! is_dir( $uploadDir )) {
			@mkdir( $uploadDir );
			chmod( $uploadDir, 0777 );			
		}
		//upload thumb image
		for($i=1;$i<=6;$i++){
			$image = new Zend_Form_Element_File( 'images'.$i );
			$image->setDestination( $uploadDir );
			$image->addValidator( 'Count', false, 1 );
			$image->addValidator( 'Extension', false, 'jpeg,jpg,png,gif' );
			$image->addFilter( 'Rename', array ('target' => $uploadDir . DIRECTORY_SEPARATOR . $i.'.jpg', 'overwrite' => true ) );
			$image->receive();
		}
//		//uploads images for gallery
//		$images = new Zend_Form_Element_File( 'images' );
//		$images->setDestination( $uploadDir );
//		//$element->addValidator ( 'Size', false, 512000 );
//		$images->addValidator( 'Extension', false, 'jpeg,jpg,png,gif' );
//		$images->setMultiFile( count( $_POST ['images'] ) );
//		$images->receive();		
//		return $images->getFileName( null, false );
	}
	public function indexAction(){
		$this->view->Title = "Management product";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->Product ) = Product::getAll ($condition,$page);
	}
	public function createAction(){
		$this->view->Title = "Management product";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {			
			$request = $this->getRequest ()->getParams ();			
			$error = $this->_checkForm ( $request );
			$Product = new Product();
			$Product->merge ( $request );
			if($Product->trySave()){
				$folder = $Product->id;
			}			
			if($_FILES['product_images']['name']){													
					$dirname = "uploads/".$folder."/";															
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['product_images'],800,600,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;						
					}									
			}	
			if($_FILES){				
				$dir = "uploads/".$Product->id."/gallery/";					
				$images = $this->_uploadFiles($dir);				
			}				
			if (count ( $error ) == 0) {				
				if($filename != ""){
				$Product->product_images = 	$filename;	
				}										
				$Product->save ();
				$this->Member->log ( 'Product:' . $Product->product_name . '(' . $Product->id . ')', 'Created' );
				My_Plugin_Libs::setSplash ( 'Create: <b>' . $Product->product_name . '</b> have been completed. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'product', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Management product";
		$this->view->headTitle ( $this->view->Title );
		$Product = Product::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($_GET) {
			$image_remove = $_GET['image'];
			$folder = $_GET['id'];
			$file = "uploads/".$_GET['id']."/gallery/".$image_remove.".jpg";
			@chmod($file, 0777);
			@unlink($file);
			echo "complete";die();			
		}
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform			
			$error = $this->_checkForm ( $request );			
			if($_FILES['product_images']['name']){					
					$dirname = "uploads/".$Product->id."/";										
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['product_images'],800,600,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;						
					}									
				}
			if($_FILES){				
				$dir = "uploads/".$Product->id."/gallery/";				
				$images = $this->_uploadFiles($dir);				
			}	
			if (count ( $error ) == 0) {
				$Product->merge ( $request );
				if($filename != ""){
				$Product->product_images = 	$filename;	
				}				
				$Product->save();
				$this->Member->log ( 'Product:' . $Product->product_name . '(' . $Product->id  . ')', 'Created' );
				My_Plugin_Libs::setSplash ( 'Create: <b>' . $Product->product_name . '</b> have been completed. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'product', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->Product = $Product;
	}
	
	public function deleteAction() {
		$Product = Product::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Product) {
			if ($this->getRequest ()->isPost ()) {
				$filename = "uploads/".str_replace("","-",$Product->product_name)."/".$Product->product_images;					
				if(is_file($filename)){
					chmod( $filename, 0777 );
					@unlink($filename);	
				}
				$Product->delete ();						
				$this->Member->log ( 'Product: ' . $Product->product_name . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Delete' );
				My_Plugin_Libs::setSplash('Delete: <b>'.$Product->product_name.'</b> have been complete.');
				$this->_redirect ( $this->_helper->url ( 'index', 'product', 'admin' ) );
			}
			$this->view->Product = $Product;
		}
	}
}