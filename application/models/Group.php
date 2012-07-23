<?php

class Application_Model_Group extends Zend_Db_Table {
    protected $_name = 'group';

    /**
     * Pobiera grupy użytkownika
     * @return array
     */
    public function getUserGroups($user_id)
    {
        return $this->select()
            ->where('user = ?', $user_id)
            ->query()
            ->fetchAll();
    }
}
