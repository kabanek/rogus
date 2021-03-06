<?php

class Application_Model_Question extends Zend_Db_Table {
	protected $_name = 'question';

	/**
	 * 
	 * @param integer $user_id
	 * @return array
	 */
	public function getUserQuestions($user_id, $order = 'id', $type = 'asc')
	{
		return $this->select()
			->where('user = ?', $user_id)
            ->order($order . ' ' . $type)
			->query()->fetchAll();
	}
	
	/**
	 *
	 * @param integer $user_id
	 * @param integer $category_id
	 * @return array
	 */
	public function getUserQuestionsInCategory($user_id, $category_id)
	{
		return $this->select()
			->where('user = ?', $user_id)
			->where('category = ?', $category_id)
			->query()->fetchAll();
	}
	
	/**
	 * Usuwa pytanie
	 * @param integer $question_id
	 * @param integer $user_id
	 */
	public function remove($question_id, $user_id)
	{
		$this->delete('id = ' . $question_id . ' AND user = ' . $user_id);
	}
	
	/**
	 * Pobiera z bazy danych pytanie
	 * @param integer $question_id
	 * @param integer $user_id
	 * @return array
	 */
	public function get($question_id, $user_id)
	{
		return $this->select()->where('id = ?', $question_id)
			->query()
			->fetch();
	}

	/**
     * Szuka pytanie używając jego ID
     */
    public function findById($id)
    {
        return $this->select()->where('id = ?', $id)->query()->fetch();
    }

    /**
     * Usuwa pytanie używając jego ID
     */
    public function deleteById($id)
    {
        return $this->select()->delete('id = ' . $id);
    }
}
