<?php

require_once 'BaseController.php';

class CategoryController extends BaseController
{
	/**
	 * Dodawanie nowej kategorii
	 */
	public function newAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$form = new Application_Form_Category_New;
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				
				$category = new Application_Model_Question_Category();
				$categoryData = array();
				$categoryData['name'] = $_POST['name'];
				$categoryData['user'] = $this->_userData['id'];
				
				$category->insert($categoryData);
				$this->_flashMessenger->setNamespace('success')->addMessage('Kategoria została dodana');
				$this->_helper->redirector('index', 'category');
			}
		}
		
		$this->view->form = $form;
	}
	
	/**
	 * Lista wszystkich kategorii
	 */
	public function indexAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$categoryTable = new Application_Model_Question_Category();

		$order = isset($_GET['order']) ?  $_GET['order']: 'id';
		$type = isset($_GET['type']) ?  $_GET['type']: 'ASC';
		
		$this->view->categories = $categoryTable->getUserCategories($this->_userData['id'], $order, $type);
	}
	
	/**
	 * usuwanie
	 */
	public function removeAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$questionTable = new Application_Model_Question_Category();
		$questionTable->remove($this->_getParam('id'), $this->_userData['id']);
		
		$this->_flashMessenger->setNamespace('success')->addMessage('Kategoria została usunięta');
		$this->_helper->redirector('index', 'category');
	}
	
	/**
	 * Edycja
	 */
	public function editAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$questionCategoryTable = new Application_Model_Question_Category;
		$category = $questionCategoryTable->get($this->_getParam('id'), $this->_userData['id']);
		
		if (!$category) {
			$this->_helper->redirector('index', 'question');
		}
				
		$form = new Application_Form_Category_Edit();
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$data = array(
						'name' 		=> $_POST['name'],
				);
				
				$questionCategoryTable->update($data, 'id = ' . $this->_getParam('id'));
				$this->_flashMessenger->setNamespace('success')->addMessage('Kategoria została zaktualizowana');
				$this->_helper->redirector('index', 'category');
			}
		} else {
			$form->setDefaults(array(
				'name'	=> $category['name'],
			));
		}
		
		$this->view->form = $form;
	}	
	
	/**
	 * Wyświetla wszystkie pytania w kategorii
	 */
	public function questionsAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$questionCategoryTable = new Application_Model_Question_Category;
		$category = $questionCategoryTable->get($this->_getParam('id'), $this->_userData['id']);
		
		if (!$category) {
			$this->_helper->redirector('index', 'category');
		}
		
		if ($category['user'] != $this->_userData['id']) {
			$this->_helper->redirector('index', 'category');
		}
		
		$questionTable = new Application_Model_Question();
		
		$this->view->questions = $questionTable->getUserQuestionsInCategory($this->_userData['id'], $this->_getParam('id'));
		
		$this->view->category = $category;
	}
}
