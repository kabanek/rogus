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

    /**
     * Szuka grupę używając jego ID
     */
    public function findById($id)
    {
        return $this->select()->where('id = ?', $id)->query()->fetch();
    }

    /**
     * Usuwa grupę używając jego ID
     */
    public function deleteById($id)
    {
        return $this->select()->delete('id = ' . $id);
    }
}
