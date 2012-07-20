<?php

class Application_Model_Test extends Zend_Db_Table {
    protected $_name = 'test';
    
    public function getUserTests($user_id)
    {
    	return $this->select()
    		->where('user = ?', $user_id)
    		->query()->fetchAll();
    }
}