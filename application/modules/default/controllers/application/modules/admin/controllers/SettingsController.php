<?php

class Admin_SettingsController extends Zend_Controller_Action {

	function init() {
		$Member = new My_Plugin_Auth( $this->getRequest() );
		$this->Member = $_SESSION ['Member'];
	}

	/**
	 * List Countries
	 */
	public function indexAction() {
		$this->view->Title = "Configuration settings";
		$this->view->headTitle( $this->view->Title );
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getParam( 'Setting' );
			$xml = '<?xml version="1.0" encoding="UTF-8"?>
					<setting>';
			foreach ( $data as $key => $value ) {
				$xml .= "\n<$key><![CDATA[$value]]></$key>";
			}
			$xml .= '</setting>';
			$fp = fopen( APPLICATION_PATH . '/configs/setting.xml', 'w' );
			fwrite( $fp, $xml );
			fclose( $fp );
			My_Plugin_Libs::setSplash( 'Configuration saved successfully' );
			$this->Member->log( 'Change system settings', 'Setting' );
		}
		$this->view->Setting = new Zend_Config_Xml( APPLICATION_PATH . '/configs/setting.xml', null );
	}

	/**
	 * Create Hotel Type
	 */
	public function createAction() {
		//Sử lý khi có yêu cầu tạo mới Hotel Type
		$form = new Admin_Form_Hoteltype_Create();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid( $_POST )) {
				$data = $form->getValues();
				$HotelType = new HotelType();
				$HotelType->merge( $data );
				$HotelType->save();
			}
			$this->_redirect( $this->_helper->url( 'index', 'hoteltype' ) );
		}
	}

	/**
	 * Edit Hotel Type via Ajax
	 */
	public function editAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		
		$HotelType = HotelType::getById( $this->getRequest()->getParam( 'id' ) );
		if ($this->getRequest()->isPost()) {
			$HotelType->merge( $_POST );
			echo ($HotelType->save());
		} else {
			$json = Zend_Json::encode( $HotelType->toArray() ); //basically, $data array will also be available in the JS.
			echo $json; //this will echo JSON to the Javascript
		}
	}

	/**
	 * Delete a Hotel Type
	 */
	public function deleteAction() {
		$HotelType = Countries::getById( $this->getRequest()->getParam( 'id' ) );
		if ($HotelType) {
			if (count( $HotelType->City ) == 0) {
				if ($this->getRequest()->isPost()) {
					
					$HotelType->delete();
					$this->_redirect( $this->_helper->url( 'index', 'location', 'admin' ) );
				}
			} else {
				$this->view->notDeleAble = 'Bạn không thể xóa <b>' . $Location->name . '</b> nếu như vẫn còn Thành phố thuộc vùng này';
			}
			$this->view->Location = $HotelType;
		}
	}

	public function homeAction() {
		$this->view->Title = "Configure home page";
		$this->view->headTitle( $this->view->Title );
		if ($this->getRequest()->isPost()) {
			$rows = $this->getRequest()->getParam( 'rows' );
			
			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml .= "\n<xml>\n	<data>";
			foreach ( $rows as $i => $row ) {
				$xml .= "\n		<rows name=\"" . htmlspecialchars( $row ['name'] ) . "\" link=\"" . htmlspecialchars( $row ['link'] ) . "\">";
				unset( $row ['name'] );
				foreach ( $row as $item ) {
					if (count( $item ) != 4)
						continue;
					$xml .= "\n			<item>";
					foreach ( $item as $key => $value )
						$xml .= "\n				<{$key}><![CDATA[{$value}]]></{$key}>";
					$xml .= "\n			</item>";
				}
				$xml .= "\n		</rows>";
			}
			
			$xml .= "\n	</data>\n</xml>";
			$fp = fopen( APPLICATION_PATH . '/configs/home.xml', 'w' );
			fwrite( $fp, $xml );
			fclose( $fp );
			My_Plugin_Libs::setSplash( 'Configuration saved successfully' );
			$this->Member->log( 'Change the configuration home page', 'Settings' );
		}
		$this->view->Data = new Zend_Config_Xml( APPLICATION_PATH . 'configs/home.xml', 'data' );
	}

	public function footerAction() {
		$this->view->Title = "Configure footer";
		$this->view->headTitle( $this->view->Title );
		if ($this->getRequest()->isPost()) {
			$rows = $this->getRequest()->getParam( 'rows' );
			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml .= "\n<xml>\n	<data>";
			foreach ( $rows as $i => $row ) {
				$xml .= "\n		<rows name=\"" . htmlspecialchars( $row ['name'] ) . "\">";
				unset( $row ['name'] );
				foreach ( $row as $item ) {
					$xml .= "\n			<item>";
					$xml .= "\n				<name><![CDATA[{$item['name']}]]></name>";
					$xml .= "\n				<value><![CDATA[{$item['value']}]]></value>";
					$xml .= "\n			</item>";
				}
				$xml .= "\n		</rows>";
			}
			$xml .= "\n	</data>\n</xml>";
			$fp = fopen( APPLICATION_PATH . '/configs/footer_link.xml', 'w' );
			fwrite( $fp, $xml );
			fclose( $fp );
			My_Plugin_Libs::setSplash( 'Configuration saved successfully' );
			$this->Member->log( 'Change the configuration footer', 'Settings' );
		}
		
		$this->view->Data = new Zend_Config_Xml( APPLICATION_PATH . 'configs/footer_link.xml', 'data' );
	}

	public function advAction() {
		$this->view->Title = "Manage ads";
		$this->view->headTitle( $this->view->Title );
		if ($this->getRequest()->isPost()) {
			$rows = $this->getRequest()->getParam( 'adv' );
			//print_r($rows);die;
			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml .= "\n<xml>\n	<data>";
			foreach ( $rows as $i => $row ) {
				$xml .= "\n		<$i limit=\"{$row['limit']}\" name=\"" . htmlspecialchars( $row ['name'] ) . "\">";
				unset( $row ['name'] );
				unset( $row ['limit'] );
				foreach ( $row as $item ) {
					$xml .= "\n			<adv>";
					foreach ( $item as $key => $value )
						$xml .= "\n				<{$key}><![CDATA[" . trim( $value ) . "]]></{$key}>";
					if (substr( $item ['file'], - 3 ) == 'swf')
						$xml .= "\n				<type><![CDATA[swf]]></type>";
					else
						$xml .= "\n				<type><![CDATA[image]]></type>";
					$xml .= "\n			</adv>";
				}
				$xml .= "\n		</$i>";
			}
			$xml .= "\n	</data>\n</xml>";
			$fp = fopen( APPLICATION_PATH . 'data/adv.xml', 'w' );
			fwrite( $fp, $xml );
			fclose( $fp );
			My_Plugin_Libs::setSplash( 'Ads have been saved' );
			$this->Member->log( 'Change ads', 'Settings' );
		}
		$dir = ROOT_DIR . DATA_DIR . '/adv';
		$this->view->Data = new Zend_Config_Xml( APPLICATION_PATH . 'data/adv.xml', 'data' );
		$this->view->Adv = self::getFileDir( $dir );
	}

	public function advfileAction() {
		$this->view->Title = "Manage advertising picture gallery";
		$this->view->headTitle( $this->view->Title );
		$dir = ROOT_DIR . DATA_DIR . '/adv';
		if ($this->getRequest()->isPost()) {
			$images = new Zend_Form_Element_File( 'images' );
			$images->setDestination( $dir );
			//$element->addValidator ( 'Size', false, 512000 );
			$images->addValidator( 'Extension', false, 'jpg,png,gif,swf' );
			$images->setMultiFile( count( $_POST ['images'] ) );
			$images->receive();
		}
		if ($this->getRequest()->getParam( 'delete' )) {
			@unlink( $dir . '/' . $this->getRequest()->getParam( 'delete' ) );
		}
		$this->view->Adv = self::getFileDir( $dir );
	}

	private function getFileDir($dir) {
		$Adv = scandir( $dir );
		foreach ( $Adv as $key => $file ) {
			if (in_array( $file, array ('.', '..', '.svn', 'thumb.db' ) )) {
				unset( $Adv [$key] );
				continue;
			}
			$Adv [$key] = My_Plugin_Libs::fileDetail( $dir . '/' . $file );
		}
		return $Adv;
	}
}

