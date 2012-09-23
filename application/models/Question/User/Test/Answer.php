<?php

class Application_Model_User_Test_Answer extends Zend_Db_Table {
	protected $_name = 'user_test_answer';
	
    /**
     * Szuka krotkę używając jego ID
     */
    public function findById($id)
    {
        return $this->select()->where('id = ?', $id)->query()->fetch();
    }

    /**
     * Usuwa krotkę używając jego ID
     */
    public function deleteById($id)
    {
        return $this->select()->delete('id = ' . $id);
    }
}
