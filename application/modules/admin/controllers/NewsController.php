<?php
class Admin_NewsController extends Zend_Controller_Action{
	function init() {
		$Member = new My_Plugin_Auth ( $this->getRequest () );
		$this->Member = $_SESSION ['Member'];		
	}
	
	private function _checkForm($form) {		
		$error = array ();
		$content = str_word_count($form ['content']);
				
		if (empty ( $form ['title'] )){
			$error [] = 'Title is required!';
		}
		if ($content == 0){
			$error [] = 'Content is required!';	
		}				
		return $error;
	}
	public function indexAction() {
		$this->view->Title = "Management news";
		$this->view->headTitle ( $this->view->Title );
		$page = $this->getRequest()->getParam('page');
		$condition = array();
		list ( $this->view->Pager, $this->view->News ) = News::getAll ($condition,$page);
	}
	public function createAction() {
		$this->view->Title = "Management news";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();											
			$error = $this->_checkForm ( $request );						
			$Content = new News ();
			$Content->merge ( $request );				
			if (count ( $error ) == 0) {
				if($Content->trySave()){
					$folder = $Content->id;
				}
				if($_FILES['images']['name']){
					$dirname = "uploads/news/".$folder."/";
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['images'],800,600,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;
					}
				}				
				if($filename != ""){
				$Content->images = $filename;
				}
				$Content->created_date = date("Y-m-d H:i:s");
				$Content->members_id = $this->Member->id;
				$Content->save ();
				$this->Member->log ( 'News:' . $Content->title . '(' . $Content->id . ')', 'Created' );
				My_Plugin_Libs::setSplash ( 'Create: <b>' . $Content->title . '</b> have been completed. ' );
				$this->_redirect ( $this->_helper->url ( 'index', 'news', 'admin' ) );	
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
	}
	
	public function editAction() {
		$this->view->Title = "Management news";
		$this->view->headTitle ( $this->view->Title );
		$Content = News::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();			
			//checkform
			$error = $this->_checkForm ( $request );
			if($_FILES['images']['name']){				
					$dir = new My_Plugin_Libs();
					$name = $dir->trimSpacer($request['title']);
					$dirname = "uploads/news/".$Content->id."/";										
					$upload = new My_Plugin_Upload();
					$error = $upload->uploadImageFile($_FILES['images'],800,600,1024000,array("image/png","image/jpg" ,"image/gif","image/x-png","image/jpeg"),$dirname);
					if(!$error){
						$filename = $upload->fileName;						
					}									
				}
			if (count ( $error ) == 0) {
				$Content->merge ( $request );
				if($filename != ""){
				$Content->images = $filename;
				}
				$Content->members_id = $this->Member->id;
				$Content->created_date = date("Y-m-d H:i:s");
				$Content->save();
				$this->Member->log ( 'News:' . $Content->title . '(' . $Content->id  . ')', 'Edited' );
				My_Plugin_Libs::setSplash ( 'Edit: <b>' . $Content->title . '</b> have been completed. ' );
				//redirect to list
				$this->_redirect ( $this->_helper->url ( 'index', 'news', 'admin' ) );
			}
			if (count ( $error ))
				$this->view->error = $error;
		}
		$this->view->News = $Content;
	}
	/**
	 * Delete a news
	 */
	public function deleteAction() {
		$Content = News::getById ( $this->getRequest ()->getParam ( 'id' ) );
		if ($Content) {
			if ($this->getRequest ()->isPost ()) {
				$Content->delete ();				
				$this->Member->log ( 'News: ' . $Content->title . '(' . $this->getRequest ()->getParam ( 'id' ) . ')', 'Delete' );
				My_Plugin_Libs::setSplash('Delete: <b>'.$Content->title.'</b> have been completed.');
				$this->_redirect ( $this->_helper->url ( 'index', 'news', 'admin' ) );
			}
			$this->view->News = $Content;
		}
	}
	/**
	 * search edit record
	 */
	public function editbysearchAction(){
		$condition =  array();
		if($this->getRequest()->isPost()){
			$textSearch = $this->getRequest()->getParam("textSearch");
			$condition  = "%".$textSearch."%";
			$Content =  News::getByName($condition);
			if($Content){
				$this->view->News = $Content;
			}else{
				$this->view->News = "false";
			}
		}		
	}
	/**
	 * search delete record
	 */
	public function deletebysearchAction(){
		$condition =  array();
		if($this->getRequest()->isPost()){
			$textSearch = $this->getRequest()->getParam("textSearch");
			$condition  = "%".$textSearch."%";
			$Content =  News::getByName($condition);
			if($Content){
				$this->view->News = $Content;
			}else{
				$this->view->News = "false";
			}
		}
	}
}