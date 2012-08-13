<?php

require_once 'BaseController.php';

class IndexController extends BaseController
{
    public function indexAction()
    {
    	$testTable = new Application_Model_Test();
    	    	
    	if ($this->_loggedIn) {
    		$q = $testTable->select()
    			->where('start_at <= NOW() AND end_at >= NOW()')
    			->query();
    		
    		$this->view->tests = $q->fetchAll();
    	} else {
    		$q = $testTable->select()
    			->where('open = 1')
	    		->where('start_at <= NOW() AND end_at >= NOW()');
    		    		
    		$this->view->tests = $q->query()->fetchAll();
    	}
    }
}

