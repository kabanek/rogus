<?php

class Application_Model_Test extends Zend_Db_Table {
    protected $_name = 'test';
    
    /**
     * Pobiera wszystkie testy, których właścicielem jest $user_id
     * @param int $user_id
     */
    public function getUserTests($user_id)
    {
    	return $this->select()
    		->where('user = ?', $user_id)
    		->query()->fetchAll();
    }
}