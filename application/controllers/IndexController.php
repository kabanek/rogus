<?php

require_once 'BaseController.php';

class IndexController extends BaseController
{
    public function indexAction()
    {
    	$testTable = new Application_Model_Test();
    	
    	if ($this->_loggedIn) {
    		$this->view->tests = $testTable->select()
    			->where('start_at >= NOW() AND end_at <= NOW()')
    			->query()
    			->fetchAll();
    	} else {
    		$this->view->tests = $testTable->select()
    			->where('open = 1')
	    		->where('start_at >= NOW() AND end_at <= NOW()')
	    		->query()
	    		->fetchAll();
    	}
    }
}

