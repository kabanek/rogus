<?php

class Application_Model_Question extends Zend_Db_Table {
	protected $_name = 'question';

	public function getUserQuestions($user_id)
	{
		return $this->select()
			->where('user = ?', $user_id)
			->query()->fetchAll();
	}
}
