<?php

class Application_Model_User_Test extends Zend_Db_Table {
	protected $_name = 'user_test';
	
	/**
	 * Pobiera wszystkie testy, które rozwiązywał użytkownik $user_id
	 * @param int $user_id
	 */
	public function getTests($user_id)
	{
		return $this->getAdapter()->query("SELECT *, ut.id as user_test_id FROM user_test as ut LEFT JOIN test as t ON t.id = ut.test WHERE ut.user = $user_id")->fetchAll();
	}
	
	/**
	 * Pobiera wszystkie pytania w teście na które odpowiadał użytkownik
	 * @param int $testUserId
	 */
	public function getQuestionsInTest($testUserId)
	{
		$q = "SELECT * FROM user_test_question as utq LEFT JOIN question as quest ON utq.question = quest.id WHERE utq.user_test = $testUserId";
		return $this->getAdapter()->query($q)->fetchAll();
	}
}
