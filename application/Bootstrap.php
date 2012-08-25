<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	function _initSession()
    {
        $session = new Zend_Session_Namespace('rogus');
    
        Zend_Registry::set('session', $session);
    }
}
