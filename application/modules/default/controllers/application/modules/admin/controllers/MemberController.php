<?php

class Admin_MemberController extends Zend_Controller_Action {
	
	function init() {
		if (! in_array ( $this->getRequest ()->getParam ( 'action' ), array ('login' ) )) {
			$Member = new My_Plugin_Auth ( $this->getRequest () );
			$this->Member = $_SESSION ['Member'];
		}
	}
	
	/**
	 * List Customer
	 */
	public function indexAction() {
		$this->view->Title = "Danh sách Thành viên";
		$this->view->headTitle ( $this->view->Title );
		//Filter Condition
		$condition = array ();
		//Filter by Keyword
		if ($this->getRequest ()->getParam ( 'keyword' )) {
			switch ($this->getRequest ()->getParam ( 'condition' )) {
				case 'name' :
					$condition ['name LIKE ?'] = "%{$this->getRequest ()->getParam ( 'keyword' )}%";
					break;
				case 'address' :
					$condition ['address LIKE ?'] = "%{$this->getRequest ()->getParam ( 'keyword' )}%";
					break;
				case 'email' :
					$condition ['email=?'] = "%{$this->getRequest ()->getParam ( 'keyword' )}%";
					break;
			}
		}
		if ($this->getRequest ()->getParam ( 'type' ) > 0) {
			$condition ['customer_type=?'] = $this->getRequest ()->getParam ( 'type' );
		}
		if ($this->getRequest ()->getParam ( 'countries_id' ) > 0) {
			$condition ['countries_id=?'] = $this->getRequest ()->getParam ( 'countries_id' );
		}
		if ($this->getRequest ()->getParam ( 'city_id' ) > 0) {
			$condition ['city_id=?'] = $this->getRequest ()->getParam ( 'city_id' );
		}
		//print_r($condition);
		$page = $this->getRequest ()->getParam ( 'page' );
		list ( $this->view->Pager, $this->view->Members ) = Members::getAll ( $condition, $page );
	}
	
	/**
	 * Create a hotel
	 */
	public function createAction() {
		$this->view->Title = "Add member";
		$this->view->headTitle ( $this->view->Title );
		//$Member = Members::getById ( $this->getRequest ()->getParam ( 'id' ) );
		$Member = new Members ();
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();
			$error = self::_checkform ( $request );
			if (! $error) {
				$Member->merge ( $request );
				$Member->username = $Member->email;
				$Member->encodePassword ();
				$Member->created_date = date ( 'Y-m-d H:i:s' );
				$Member->save ();
				$this->Member->log ( 'Add member:' . $Member->getName () . '(' . $Member->id . ')', 'Member' );
				My_Plugin_Libs::setSplash ( 'Member:<b>' . $Member->getName () . '</b>has been more successful.' );
				$this->_redirect ( $this->_helper->url ( 'index', 'member', 'admin' ) );
			
			} else {
				$this->view->error = $error;
			}
		}
		$this->view->Member = $Member;
	}
	public function editAction() {
		$this->view->Title = "Edit Profile";
		$this->view->headTitle ( $this->view->Title );
		$Member = Members::getById ( $this->getRequest ()->getParam ( 'id' ) );
		
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();
			$error = self::_checkformedit ( $request );
			if (! $error) {
				$Member->merge ( $request );
				$Member->username = $Member->email;
				$Member->encodePassword ();
				$Member->save ();
				$this->Member->log ( 'Edit member:' . $Member->getName () . '(' . $Member->id . ')', 'Member' );
				My_Plugin_Libs::setSplash ( 'Member:<b>' . $Member->getName () . '</b>have successful change!.' );
				$this->_redirect ( $this->_helper->url ( 'index', 'member', 'admin' ) );
			} else {
				$this->view->error = $error;
			}
		}
		$this->view->Member = $Member;
	}
	
	public function historyAction() {
		$this->view->Title = "Diary of member activities";
		$this->view->headTitle ( $this->view->Title );
		if ($this->getRequest ()->getParam ( 'id' ) != '') {
			$id = $this->getRequest ()->getParam ( 'id' );
			
			$file_path = APPLICATION_PATH . 'data/member_' . $id . '.log.csv';
			if (file_exists ( $file_path )) {
				$fp = file ( $file_path );
				$lines = count ( $fp );
				
				$linesPerPage = 50;
				$totalPages = ceil ( $lines / $linesPerPage );
				$page = ( int ) $this->getRequest ()->getParam ( 'page' );
				$page = ($page) ? $page : 1;
				$cLine = ($page * $linesPerPage) - $linesPerPage;
				$this->view->TotalPage = $totalPages;
				$this->view->Pager = $page;
				$this->view->id = $id;
				
				$aLogs = array_slice ( $fp, $cLine, $linesPerPage );
				unset ( $fp );
				$fields = array ('time', 'ip', 'section', 'action' );
				foreach ( $aLogs as $i => $log ) {
					$log = explode ( ',', str_replace ( '"', '', $log ) );
					foreach ( $fields as $key => $field ) {
						$log [$field] = $log [$key];
						unset ( $log [$key] );
					}
					$aLogs [$i] = $log;
				}
				$this->view->Log = $aLogs;
			
			} else {
				$this->view->error = 'This user has not had any activity should be monitored';
			}
		
		}
	}	
	
	public function loginAction() {
		$this->_helper->layout->disableLayout ();
		if ($this->getRequest ()->isPost ()) {
			$email = $this->getRequest ()->getParam ( 'username' );
			$password = $this->getRequest ()->getParam ( 'password' );
			$Members = Members::setLogin ( $email, $password );
			if ($Members) {
				$Members->setLastLogin ();
				$_SESSION ['Member'] = $Members;
				$_SESSION ['Role'] = Zend_Json::decode ( Groups::getById ( $Members->member_type )->role );
				$this->_redirect ( 'admin' );
			} else {
				$this->view->error = 'Login incorrect';
			}
		}
	}
	
	public function logoutAction() {
		$this->Member->log ( 'Signed out', 'Members' );
		$storage = new Zend_Auth_Storage_Session ();
		$storage->clear ();
		unset ( $_SESSION ['Member'], $_SESSION ['Role'] );
		session_destroy ();
		$this->_redirect ( '/admin' );
	}
	
	public static function _checkformedit($data = array()) {
		
		foreach ( array ('email', 'name', 'status', 'member_type' ) as $a ) {
			if ($data [$a] == '')
				$error [] = ucfirst ( $a ) . ' is required';
		}
		if ($data ['password'] != '') {
			if (strlen ( $data ['password'] ) <= 4)
				$error [] = 'Password must have at least 4 characters';
		}
		if ($data ['password'] != $data ['confirmpassword']) {
			$error [] = 'Password and confirm password not same';
		} else {
		}
		
		//Check Email
		if ($data ['email']) {
			$validator = new Zend_Validate_EmailAddress ();
			if (! $validator->isValid ( $data ['email'] ))
				$error [] = 'Multiple formats email!';
		}
		return $error;
	}
	
	public static function _checkform($data = array()) {
		
		foreach ( array ('email', 'password', 'confirmpassword', 'status', 'member_type' ) as $a ) {
			if ($data [$a] == '')
				$error [] = ucfirst ( $a ) . ' is required';
		}
		if ($data ['name'] == '')
			$error [] = 'Member name is required';
		if ($data ['password'] != $data ['confirmpassword']) {
			$error [] = 'Password and confirm password not same';
		} else {
		}
		
		//Check Email
		if ($data ['email']) {
			$validator = new Zend_Validate_EmailAddress ();
			if (! $validator->isValid ( $data ['email'] ))
				$error [] = 'Multiple formats email!';
			else {
				$User = Members::getByEmail ( $data ['email'] );
				if ($User)
					$error [] = $data ['email'] . ' was used, please enter another email address!';
			}
		}
		//check password
		if (strlen ( $data ['password'] ) <= 4)
			$error [] = 'Password must have at least 4 characters';
		return $error;
	}
	
	public static function _checkformmy($data = array()) {
		
		foreach ( array ('email', 'name' ) as $a ) {
			if ($data [$a] == '')
				$error [] = ucfirst ( $a ) . ' is required';
		}
		if ($data ['password'] != '') {
			if (strlen ( $data ['password'] ) <= 4)
				$error [] = 'Password must have at least 4 characters';
		}
		if ($data ['password'] != $data ['confirmpassword']) {
			$error [] = 'Password and confirm password not same';
		} else {
		}
		
		//Check Email
		if ($data ['email']) {
			$validator = new Zend_Validate_EmailAddress ();
			if (! $validator->isValid ( $data ['email'] ))
				$error [] = 'Multiple formats email';
		}
		return $error;
	}
	
	public function myAction() {
		$this->view->Title = "View Public Profile";
		$this->view->headTitle ( $this->view->Title );
		$id = $this->Member->id;
		$Member = Members::getById ( $id );
		if ($Member) {
			$file_path = APPLICATION_PATH . 'data/member_' . $id . '.log.csv';
			if (file_exists ( $file_path )) {
				$fp = file ( $file_path );
				$lines = count ( $fp );
				
				$linesPerPage = 50;
				$totalPages = ceil ( $lines / $linesPerPage );
				$page = ( int ) $this->getRequest ()->getParam ( 'page' );
				$page = ($page) ? $page : 1;
				$cLine = ($page * $linesPerPage) - $linesPerPage;
				$this->view->TotalPage = $totalPages;
				$this->view->Pager = $page;
				$this->view->id = $id;
				
				$aLogs = array_slice ( $fp, $cLine, $linesPerPage );
				unset ( $fp );
				$fields = array ('time', 'ip', 'section', 'action' );
				foreach ( $aLogs as $i => $log ) {
					$log = explode ( ',', str_replace ( '"', '', $log ) );
					foreach ( $fields as $key => $field ) {
						$log [$field] = $log [$key];
						unset ( $log [$key] );
					}
					$aLogs [$i] = $log;
				}
				$this->view->Log = $aLogs;
			
			} else {
				$this->view->error = 'This user has not had any activity should be monitored';
			}
		
		}
		$this->view->My = $Member;
	}
	
	public function profileAction() {
		$this->view->Title = "Edit personal information";
		$this->view->headTitle ( $this->view->Title );
		$id = $this->Member->id;
		$Member = Members::getById ( $id );
		if ($this->getRequest ()->isPost ()) {
			$request = $this->getRequest ()->getParams ();
			unset ( $request ['id'] );
			if ($request ['password'] == '' || $request ['password'] != $request ['confirmpassword'] || $request ['confirmpassword'] == '') {
				unset ( $request ['password'], $request ['confirmpassword'] );
				$Member->merge ( $request );
				$Member->username = $Member->email;
				$Member->save ();
			} else {
				$Member->merge ( $request );
				$Member->username = $Member->email;
				$Member->encodePassword ();
				$Member->save ();
			}
			$this->Member->log ( 'Edit member:' . $Member->getName () . '(' . $Member->id . ')', 'Member' );
			My_Plugin_Libs::setSplash ( 'Member: <b>' . $Member->getName () . '</b> have successfull changed' );
			$this->_redirect ( $this->_helper->url ( 'index', 'index', 'admin' ) );
		}
		$this->view->Member = $Member;
	
	}	
	
	
	public function loginforgotAction() {
		$this->view->Title = "For gotten password";
		$this->view->headTitle( $this->view->Title );
		$error = '';
		$id = 7;
		$Content = Content::getById ( $id );
		if ($this->getRequest ()->isPost ()) {
			$Request = $this->getRequest ()->getParams ();
			$Member = Members::getByEmail ( $Request ['email'] );
			if ($Member) {
				$String = My_Plugin_Libs::randomStr ();
				$Member->encodePassword ( $String );
				$Member->save ();
				$message = str_replace ( array ('%email%', '%password%' ), array ($Member->email, $String ), $Content ['content'] );
				$to = $Member->email;
				$subject = $Content->title;
				$oEmail = new My_Plugin_Email ();
				$oEmail->send ( $subject, $to, '', $message );
				$error = 'Password has been sent to your email!';
			} else {
				$error = 'Email is not macth please try again!';
			}
		}
	}
}