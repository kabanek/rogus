<?php

class Application_Model_Question extends Zend_Db_Table {
	protected $_name = 'question';

	/**
	 * 
	 * @param integer $user_id
	 * @return array
	 */
	public function getUserQuestions($user_id)
	{
		return $this->select()
			->where('user = ?', $user_id)
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
			->where('user = ?', $user_id)
			->query()
			->fetch();
	}
}
