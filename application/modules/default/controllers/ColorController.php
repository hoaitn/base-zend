<?php

class ColorController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $this->view->Title = 'Màu xe - Phong thủy';
		$this->view->headTitle ( $this->view->Title );
		$condition = array();
		$page = $this->getRequest()->getParam('page');
		list ( $this->view->Pager, $this->view->Color ) = Color::getAll ($condition, $page, 40, $order = 'id DESC');
    }   
}
