<?php
class ProductGroup extends BaseProductGroup{
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
	public static function getOption() {
		$Content = Doctrine_Query::create ()->from ( __CLASS__ )->execute()->toArray();
		foreach($Content as $key=>$value){
			$Option[$value['id']] = $value['name'];			
		}
		return $Option;
	}
	public static function getAllNoPage() {
		$Content = Doctrine_Query::create ()->from ( __CLASS__ )->execute()->toArray();
		foreach($Content as $key=>$value){
			$Option[$value['id']] = $value['name'];		
		}
		return $Option;
	}	
}