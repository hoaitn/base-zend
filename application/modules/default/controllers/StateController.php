<?php

class StateController extends Zend_Controller_Action
{
    public function indexAction ()
    {
		$stateId = $this->getRequest()->getParam('id');

		$condition = array('stateNo =?' => $stateId );
		$page = $this->getRequest()->getParam('page');
		$request = $this->getRequest()->getParams();	
		$this->view->nameplain = $request['name_plain'];		
		list ( $this->view->Pager, $this->view->trainers ) = Trainer::getAll ($condition, $page, 50, $order = 'lastName,firstName');

		/** Get state name **/
		$state = State::getById($stateId);

		
		switch($state->name) {
			case "NSW": $this->view->Title = "Racehorse Trainers in New South Wales"; break;
			case "VIC": $this->view->Title = "Racehorse Trainers in Victoria"; break;
			case "QLD": $this->view->Title = "Racehorse Trainers in Queensland"; break;
			case "TAS": $this->view->Title = "Racehorse Trainers in Tasmania"; break;
			case "SA": $this->view->Title = "Racehorse Trainers in South Australia"; break;
			case "WA": $this->view->Title = "Racehorse Trainers in Western Australia"; break;
			case "NT": $this->view->Title = "Racehorse Trainers in Northern Territory"; break;
			case "ACT": $this->view->Title = "Racehorse Trainers in Australian Capital Territory"; break;
		}
		$this->view->headTitle ( $this->view->Title );
		$this->view->active = "state";
		
    }
}
