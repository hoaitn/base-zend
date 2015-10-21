<?php
class Color extends BaseColor{
	public static function getAll($Condition = array(), $currentPage = 1, $recordPerPage = 20, $orderBy = 'id') {
		$Content = Doctrine_Query::create ()->from ( __CLASS__ )->orderBy ( $orderBy );
		foreach ( $Condition as $key => $item ) {
			$Content->addWhere ( $key, $item );
		}
		$pager = new Doctrine_Pager ( $Content, $currentPage, $recordPerPage );
		$Data = $pager->execute ();
		return array ($pager, $Data );
	}
	public static function getById($id = 0) {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'id=?', $id )->execute()->getFirst ();
	}
	public static function getByName($name_plain = "") {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'name_plain=?', $name_plain )->execute ()->getFirst ();
	}
	public function getCreatedDate() {
		return $this->created_date;
	}
	public function getLink() {
		return Zend_Registry::get('Setting')->DOMAIN . '/content/' . $this->name_plain . Zend_Registry::get('Setting')->page_ext;
	}
	public function getThumbImage() {		
		$file_path = DATA_DIR . "color/" . $this->id .'/'.$this->image;
		return $file_path;
	}
}