<?php


class Trainer extends BaseTrainer {

	public static function getAll($Condition = array(), $currentPage = 1, $recordPerPage = 10, $order = 'trainersListId') {
		
		$Trainer = Doctrine_Query::create()->from( __CLASS__ )->orderBy( $order );
		foreach ( $Condition as $key => $item ) {
			$Trainer->addWhere( $key, $item );		
			
		}				
		$pager = new Doctrine_Pager( $Trainer, $currentPage, $recordPerPage );
		$Data = $pager->execute();
		return array ($pager, $Data );
	}
	public static function getAllBySearch($Condition = array(), $currentPage = 1, $recordPerPage = 10, $order = 'trainersListId') {
		
		$Trainer = Doctrine_Query::create()->from( __CLASS__ )->orderBy( $order );
		foreach ( $Condition as $key => $item ) {
			$Trainer->orWhere( $key, $item );		
			
		}				
		$pager = new Doctrine_Pager( $Trainer, $currentPage, $recordPerPage );
		$Data = $pager->execute();
		return array ($pager, $Data );
	}
	public static function getById($id = 0) {
		return Doctrine_Query::create()->from( __CLASS__ )->where( 'trainersListId=?', $id )->execute()->getFirst();
	}

	public static function getByNamePlain($id = 0) {
		return Doctrine_Query::create()->from( __CLASS__ )->where( 'name_plain=?', $id )->execute()->getFirst();
	}
	
	public function getLink() {
		return '/' . $this->Trainer->name_plain . '/' . $this->name_plain. Zend_Registry::get( 'Setting' )->page_ext;
	}

	
	public static function DeleteById($id = 0) {
		Doctrine_Query::create()->delete( __CLASS__ )->where( 'trainersListId=?', $id )->execute();
	}	
	
	public function getGMapData ($postCode) { 
		$trainers = Doctrine_Query::create()->from( __CLASS__ )->where('postCode=?',$postCode)->execute()->toArray();
		for ($i = 0; $i < count($trainers); $i++) {
            $trainerList[$i]['trainersListId'] = $trainers[$i]['trainersListId'];
            $trainerList[$i]['firstName'] = $trainers[$i]['firstName'];
            $trainerList[$i]['lastName'] = $trainers[$i]['lastName'];            
            $trainerList[$i]['phone'] = $trainers[$i]['phone'];
            $trainerList[$i]['email'] = $trainers[$i]['email'];
            $trainerList[$i]['website'] = $trainers[$i]['website']; 
            $trainerList[$i]['city'] = $trainers[$i]['city'];
            $trainerList[$i]['postcode'] = $trainers[$i]['postCode'];
            $trainerList[$i]['lat'] = $trainers[$i]['lat'];
            $trainerList[$i]['lon'] = $trainers[$i]['lon'] ;
            $trainerList[$i]['type'] = $trainers[$i]['type'] ;
            $trainerList[$i]['total'] = count($trainers);			
		}
		
		return $trainerList;		
	}
	
	public function getAllPostcode($Condition = array()) {
	
		$postcode = Doctrine_Query::create()->from( __CLASS__ );
		// Taken Out By Darryl
		//foreach ( $Condition as $key => $item ) {
			//$postcode->where( $item );		
		//}
		
		// Added By Darryl
		$postcode->where( "city !='' AND postCode !='' AND lon !='' AND lat !='' AND phone !=''" );	
		$postcode->groupBy( 'postCode' );	
		$postcode->orderBy( 'postCode ASC' );
		//echo $postcode->getSqlQuery();
		//
		
		$data = $postcode->execute()->toArray();
		for ($i = 0; $i < count($data); $i++) {
			$postcodeList[$i] = $data[$i]['postCode']; 
		}
		if($postcodeList){
			return array_unique($postcodeList);
		}
	}
	
	public static function getByState($stateId) {
		$trainers = Doctrine_Query::create()->from(__CLASS__)->where("stateNo=?",$stateId)->execute()->toArray();
		return $trainers;
	}
}