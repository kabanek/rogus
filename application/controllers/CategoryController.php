<?php

require_once 'BaseController.php';

class CategoryController extends BaseController
{
	public function newAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		if ($this->_config->getConfig('site/type') == 'closed') {
			if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
				$this->_helper->redirector('index', 'index');
			}
		}
		
		$form = new Application_Form_Category_New;
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				
				$category = new Application_Model_Question_Category();
				$categoryData = array();
				$categoryData['name'] = $_POST['name'];
				$categoryData['user'] = $this->_userData['id'];
				
				$category->insert($categoryData);
								
				$this->_helper->redirector('index', 'category');
			}
		}
		
		$this->view->form = $form;
	}
	
	public function indexAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		if ($this->_config->getConfig('site/type') == 'closed') {
			if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
				$this->_helper->redirector('index', 'index');
			}
		}
		
		$categoryTable = new Application_Model_Question_Category();
		
		$this->view->categories = $categoryTable->getUserCategories($this->_userData['id']);
	}
	
	public function removeAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		if ($this->_config->getConfig('site/type') == 'closed') {
			if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
				$this->_helper->redirector('index', 'index');
			}
		}
		
		$questionTable = new Application_Model_Question_Category();
		$questionTable->remove($this->_getParam('id'), $this->_userData['id']);
		
		$this->_helper->redirector('index', 'category');
	}
	
	public function editAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		if ($this->_config->getConfig('site/type') == 'closed') {
			if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
				$this->_helper->redirector('index', 'index');
			}
		}
		
		$questionTable = new Application_Model_Question;
		$question = $questionTable->get($this->_getParam('id'), $this->_userData['id']);
		
		if (!$question) {
			$this->_helper->redirector('index', 'question');
		}
		
		$questionOptionTable = new Application_Model_Question_Option;
		
		$options = $questionOptionTable->getByQuestion($this->_getParam('id'));
		
		$form = new Application_Form_Question_Edit();
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$data = array(
						'text' 		=> $_POST['text'],
						'weight' 	=> $_POST['weight'],
				);
				
				$questionTable->update($data, 'id = ' . $this->_getParam('id'));
				$this->_helper->redirector('index', 'question');
			}
		} else {
			$form->setDefaults(array(
				'name'	=> $question['text'],
				'weight'=> $question['weight']
			));
		}
		
		$this->view->form = $form;
	}
}
