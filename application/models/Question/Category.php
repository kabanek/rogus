<?php

class Application_Model_Question_Category extends Zend_Db_Table {
	protected $_name = 'question_category';
	
	/**
	 * pobiera wszystkie kategorie, których autorem jest user_id
	 * @param unknown_type $user_id
	 */
	public function getUserCategories($user_id, $order = 'id', $type='asc')
	{
		return $this->select()
			->where('user = ?', $user_id)
			->order($order . ' ' . $type)
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
	
	/**
	 * Pobiera z bazy danych kategorię
	 * @param integer $category_id
	 * @param integer $user_id
	 * @return array
	 */
	public function get($category_id, $user_id)
	{
		return $this->select()->where('id = ?', $category_id)
			->where('user = ?', $user_id)
			->query()
			->fetch();
	}
	
	/**
	 * Pobiera wszystkie pytania, które należą do kategorii
	 * @param unknown_type $cat_id
	 */
	public function getQuestions($cat_id)
	{
		$questionTable = new Application_Model_Question;
		
		return $questionTable->select()
			->where('category = ?', $cat_id)
			->query()
			->fetchAll();
	}
}
