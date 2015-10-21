<?php
class Product extends  BaseProduct{
	public static function getAll($Condition = array(), $currentPage = 1, $recordPerPage = 20, $orderBy = 'id') {
		$Content = Doctrine_Query::create ()->from ( __CLASS__ )->orderBy ( $orderBy );
		foreach ( $Condition as $key => $item ) {
			$Content->addWhere ( $key, $item );
		}
		$pager = new Doctrine_Pager ( $Content, $currentPage, $recordPerPage );
		$Data = $pager->execute ();
		return array ($pager, $Data );
	}
	public static function getDataNotPage(){
		return Doctrine_Query::create ()->from ( __CLASS__ )->orderBy ( "id DESC" )->limit(6)->execute();
	} 
	public static function getSoldOut() {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'sold_out=?', 1 )->orderBy ( "id DESC" )->limit(9)->execute();
	}
	public static function getNewStatus() {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'new_status=?', 1 )->orderBy ( "id DESC" )->limit(9)->execute();
	}
	public static function getById($id = 0) {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'id=?', $id )->execute()->getFirst ();
	}	
	public function getCreatedDate() {
		return $this->created_date;
	}
	public static function getByGroupId($id = 0){
		return Doctrine_Query::create ()->from ( __CLASS__ )->Where ( 'id_group_product=?', $id )->execute();
	}
	public function getThumbImage() {
		$file_path = DATA_DIR  . $this->id .'/'.$this->product_images;
		return $file_path;
	}
	public static function getSearchProduct($textSearch) {
		return  Doctrine_Query::create ()->from ( __CLASS__ )->Where ( 'product_name LIKE?', $textSearch )->execute();
	}	
}