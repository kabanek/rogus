<?php

class Application_Model_Question_Category extends Zend_Db_Table {
	protected $_name = 'question_category';
	
	public function getUserCategories($user_id)
	{
		return $this->select()
			->where('user = ?', $user_id)
			->query()
			->fetchAll();
	}
	
	/**
	 * Usuwa kategorii
	 * @param integer $category_id
	 * @param integer $user_id
	 */
	public function remove($category_id, $user_id)
	{
		$this->delete('id = ' . $category_id . ' AND user = ' . $user_id);
	}
}
