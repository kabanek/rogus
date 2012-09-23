<?php

class Application_Model_Question_Option extends Zend_Db_Table {
	protected $_name = 'question_option';
	
	/**
	 * 
	 * @param int $question_id
	 * @return array
	 */
	public function getByQuestion($question_id)
	{
		return $this->select()->where('question = ?', $question_id)
			->order('id ASC')
			->query()
			->fetchAll();
	}
	
	/**
	 * Usuwa wszystkie odpowiedzi do pytania
	 * @param unknown_type $question_id
	 */
	public function deleteAllOptions($question_id)
	{
		$this->delete('question = ' . $question_id);
	}
	
	/**
	 * Pobiera tylko poprawne odpowiedzi w pytaniu
	 * @param int $question_id
	 */
	function getOnlyCorrectOptions($question_id)
	{
		return $this->select()->where('question = ?', $question_id)
			->where('correct = ?', 1)
			->order('id ASC')
			->query()
			->fetchAll();
	}

	/**
     * Szuka odpowieź do pytania używając jego ID
     */
    public function findById($id)
    {
        return $this->select()->where('id = ?', $id)->query()->fetch();
    }

    /**
     * Usuwa odpowiedź do pytania używając jego ID
     */
    public function deleteById($id)
    {
        return $this->select()->delete('id = ' . $id);
    }
}
