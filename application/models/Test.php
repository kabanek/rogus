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

    /**
     * Szuka test używając jego ID
     */
    public function findById($id)
    {
        return $this->select()->where('id = ?', $id)->query()->fetch();
    }

    /**
     * Usuwa test używając jego ID
     */
    public function deleteById($id)
    {
        return $this->select()->delete('id = ' . $id);
    }
}