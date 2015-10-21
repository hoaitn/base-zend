<?php
class News extends BaseNews{
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
	public static function getByGroupId($id = 0) {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'group_id=?', $id )->orderBy ( 'id DESC' )->limit(5)->execute();
	}
	public static function getByName($name = "") {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'title = ?', $name )->execute ()->getFirst ();
	}
	public function getCreatedDate() {
		return $this->created_date;
	}
	public function getLink() {
		return Zend_Registry::get('Setting')->DOMAIN . '/content/' . $this->name_plain . Zend_Registry::get('Setting')->page_ext;
	}
	public function getThumbImage() {	
		$file_path = DATA_DIR . "news/" . $this->id .'/'.$this->images;
		return $file_path;
	}
	public static  function getRandomContent($category){
		$categories = Doctrine_Query::create()->from('NewGroup')->where('id = ?',$category)->fetchOne();
		$content = Doctrine_Query::create()->from(__CLASS__)->where('group_id = ?',$categories->id)->orderBy('RAND()')->execute()->toArray();
		return $content;
	}
}
?>