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
	
	public function deleteAllOptions($question_id)
	{
		$this->delete('question = ' . $question_id);
	}
}
