<?php

class ErrorController extends Zend_Controller_Action
{
    private $_notifier;
    private $_error;
    private $_environment;
    private $_mailer;
    private $_session;
    private $_profiler;

    public function init()
    {

        $bootstrap = $this->getInvokeArg('bootstrap');
        
        $this->_environment = $bootstrap->getEnvironment();
        //$db = $bootstrap->getResource('db');
        //$profiler = $db->getProfiler();
        
        $this->_mailer =  new Zend_Mail();
        $this->_error = $this->_getParam('error_handler');
        $this->_session = new Zend_Session_Namespace();
        //$this->_profiler = $profiler;
        $this->_server = $_SERVER;
    }
    
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->environment =  $this->_environment;
            $this->view->errors      =  $this->_error;
            $this->view->session     =  $this->_session;
            $this->view->server      =  $this->_server;
			//$this->view->exception = $errors->exception;
            //TODO 
            //$query = $this->_profiler->getLastQueryProfile();
            //$this->view->query = $query;
            
        }
        
        $this->view->request   = $this->_error->request;
        $this->view->request   = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

