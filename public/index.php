<?php
require realpath('../application').'/config.php';
/** Zend_Application */
require_once 'Zend/Application.php';
$application = new Zend_Application ( APPLICATION_ENV, APPLICATION_PATH . 'configs/application.ini' );
Zend_Session::start ();
    
    /**
     * Thiết lập không hiển thị lỗi nếu là phiên bản production
     *
     */
    if ('production' !== APPLICATION_ENV) {
        $application->getAutoloader()->suppressNotFoundWarnings(false);
    }

$application->bootstrap ()->run ();
