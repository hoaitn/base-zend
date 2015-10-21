<?php

/**
 * Groups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Groups extends BaseGroups {
	public static function getAll($Condition = array()) {
		$Countries = Doctrine_Query::create ()->from ( __CLASS__ )->orderBy ( 'name' );
		foreach ( $Condition as $key => $item ) {
			$Countries->addWhere ( $key, $item );
		}
		return $Countries->execute ();
	}
	
	public static function getById($id = 0) {
		return Doctrine_Query::create ()->from ( __CLASS__ )->where ( 'id=?', $id )->execute ()->getFirst ();
	}
	public static function getOption($Option = array()) {
		$Content = Doctrine_Query::create ()->from ( __CLASS__ )->execute()->toArray();
		foreach($Content as $key=>$value){
			$Option[$value['id']] = $value['name'];		
		}
		return $Option;
	}
}