<?php

class Application_Model_User_Test_Answer extends Zend_Db_Table {
	protected $_name = 'user_test_answer';
	
	/**
	 * Pobiera wszystkie odpowiedzi jakie udzielił użytkownik do testu w pytaniu $question
	 * @param int $userTest
	 * @param int $question
	 * @return array
	 */
	function getAnswers($userTest, $question)
	{
		$q = "SELECT * FROM user_test_answer as uta LEFT JOIN  question_option AS qo ON qo.id = uta.answer WHERE uta.question = $question AND uta.user_test = $userTest";
		return $this->getAdapter()->query($q)->fetchAll();
	}

	/**
     * Szuka odpowiedź użytkownika na pytanie w teście używając jego ID
     */
    public function findById($id)
    {
        return $this->select()->where('id = ?', $id)->query()->fetch();
    }

    /**
     * Usuwa odpowiedź użytkownika na pytanie w teście używając jego ID
     */
    public function deleteById($id)
    {
        return $this->select()->delete('id = ' . $id);
    }
}
