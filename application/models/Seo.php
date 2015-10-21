<?php


class Seo extends BaseSeo {	
	public static function getOption($cities = array()) {
		$State = Doctrine_Query::create()->from( __CLASS__ )->execute();
		foreach ( $State as $Stated ) {
			$states [$Stated->id] = $Stated->name;
		}
		return $states;
	}
	
	public static function getAll($Condition = array(), $currentPage = 1, $recordPerPage, $order = '') {
		
		$State = Doctrine_Query::create()->from( __CLASS__ )->orderBy( $order );
		foreach ( $Condition as $key => $item ) {
			$State->addWhere( $key, $item );
		}
		$pager = new Doctrine_Pager( $State, $currentPage, $recordPerPage );
		$Data = $pager->execute();
		return array ($pager, $Data );
	}

	public static function getById($id = 0) {
		return Doctrine_Query::create()->from( __CLASS__ )->where( 'stateId=?', $id )->execute()->getFirst();
	}	
	public function getLink() {
		return '/' . $this->State->name_plain . '/' . $this->name_plain. Zend_Registry::get( 'Setting' )->page_ext;
	}

	
	public static function DeleteById($id = 0) {
		Doctrine_Query::create()->delete( __CLASS__ )->where( 'stateId=?', $id )->execute();
	}	
	
	public static function getListing() {
		$state = Doctrine_Query::create()->from( __CLASS__ )->execute();
		
		foreach ( $state as $item ) {
			$list[$item->stateId] = $item->name;
		}
		return $list;
	}
	
}