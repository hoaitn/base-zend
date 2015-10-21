<?php
class NewGroup extends BaseNewGroup{
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
	public static function getBySetionId($id = 0) {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'setions_id=?', $id )->orderBy ( "id" )->execute();
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
	public static function getOption($Option = array()) {
		$Content = Doctrine_Query::create ()->from ( __CLASS__ )->execute()->toArray();
		foreach($Content as $key=>$value){
			$Option[$value['id']] = $value['name'];
		}
		return $Option;
	}
}