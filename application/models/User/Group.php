<?php

class Application_Model_User_Group extends Zend_Db_Table {
	protected $_name = 'user_group';
	
	public function getUserGroups($user_id)
	{
		return $this->getAdapter()->query('SELECT * FROM `group` as gr LEFT JOIN user_group u_gr ON gr.id = u_gr.group WHERE u_gr.user = ' . $user_id)->fetchAll();
	}

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
