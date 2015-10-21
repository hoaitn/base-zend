<?php
class NewsController extends Zend_Controller_Action{
	public function indexAction(){		
		$group = $this->getRequest()->getParam("group");		
		$condition = array("group_id=?"=>$group);
		$page = $this->getRequest()->getParam('page');
		list ( $this->view->Pager, $this->view->News ) = News::getAll ($condition, $page, 10, $order = 'id DESC');
		$this->view->Group = $group;
		$GroupName = NewGroup::getById($group);			
		$this->view->Title = $GroupName->name;
		$this->view->headTitle ( $this->view->Title );
	}
	public function detailsAction(){
		$group = $this->getRequest()->getParam("group");
		$GroupName = NewGroup::getById($group);
		$id = $this->getRequest()->getParam("id");
		$this->view->Details = News::getById($id);
		$this->view->Deffirent = News::getByGroupId($group);
		$this->view->Title = $GroupName->name;
		$this->view->headTitle ( $this->view->Title );
	}
	public function whyAction(){
		
	}
}