<?php

require_once 'BaseController.php';

class TestController extends BaseController
{
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
		
		$testTable = new Application_Model_Test();
		
		$this->view->tests = $testTable->getUserTests($this->_userData['id']);
	}
	
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
		
		$form = new Application_Form_Test_New;
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$testTable = new Application_Model_Test();
				$questionData = array();
				$questionData['open'] 				= $_POST['open'];
				$questionData['name'] 				= $_POST['name'];
				$questionData['points'] 			= $_POST['points'];
				$questionData['start_at'] 			= $_POST['start_at'];
				$questionData['end_at'] 			= $_POST['end_at'];
				$questionData['time'] 				= $_POST['time'];
				$questionData['quastions_limit'] 	= $_POST['quastions_limit'];
				$questionData['user'] 				= $this->_userData['id'];
								
				$test_id = $testTable->insert($questionData);
				$testCategoryTable = new Application_Model_Test_Category;
				
				foreach ($_POST['categories'] as $cat_id) {
					$testCategoryTable->insert(array(
							'test'		=> $test_id,
							'category'	=> $cat_id,
					));
				}
				
				$this->_flashMessenger->setNamespace('success')->addMessage('Test został dodany');
				$this->_helper->redirector('index', 'test');
			}
		}
		
		$this->view->form = $form;
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
	
		$form = new Application_Form_Test_New;
		$testTable = new Application_Model_Test();
		
		$test = $testTable->find($this->_getParam('id'))->getRow(0)->toArray();
	
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$questionData = array();
				$questionData['open'] 				= $_POST['open'];
				$questionData['name'] 				= $_POST['name'];
				$questionData['points'] 			= $_POST['points'];
				$questionData['start_at'] 			= $_POST['start_at'];
				$questionData['end_at'] 			= $_POST['end_at'];
				$questionData['time'] 				= $_POST['time'];
				$questionData['quastions_limit'] 	= $_POST['quastions_limit'];
				$questionData['user'] 				= $this->_userData['id'];
	
				$test_id = $testTable->insert($questionData);
				$testCategoryTable = new Application_Model_Test_Category;
	
				foreach ($_POST['categories'] as $cat_id) {
					$testCategoryTable->insert(array(
							'test'		=> $test_id,
							'category'	=> $cat_id,
					));
				}
	
				$this->_flashMessenger->setNamespace('success')->addMessage('Test został dodany');
				$this->_helper->redirector('index', 'test');
			}
		} else {			
			$form->setDefaults(array(
					'name'	=> $test['name'],
					'open'	=> $test['open'],
					'points'	=> $test['points'],
					'start_at'	=> $test['start_at'],
					'end_at'	=> $test['end_at'],
					'time'	=> $test['time'],
					'quastions_limit'	=> $test['quastions_limit'],
			));
		}
	
		$this->view->form = $form;
	}
	
	public function removeAction()
	{
		$testTable = new Application_Model_Test();
		$testTable->delete('id = ' .$this->_getParam('id'));
		
		$this->_flashMessenger->setNamespace('success')->addMessage('Test został usunięty');
		$this->_helper->redirector('index', 'test');
	}
}
