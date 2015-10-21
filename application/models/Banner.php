<?php
class Banner extends  BaseBanner{
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
	public static function getById($id = 0) {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'id=?', $id )->execute()->getFirst ();
	}
	public function getThumbImage() {
		$file_path = DATA_DIR  ."banner/". $this->id .'/'.$this->image;
		return $file_path;
	}
}