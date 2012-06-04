<?php

require_once 'BaseController.php';

class QuestionController extends BaseController
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
		
		$form = new Application_Form_Question_New;
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				
				$question = new Application_Model_Question();
				$questionData = array();
				$questionData['text'] = $_POST['text'];
				$questionData['weight'] = $_POST['weight'];
				$questionData['user'] = $this->_userData['id'];
				
				$question->insert($questionData);
				$question_id = $question->getAdapter()->lastInsertId();
				
				$option = new Application_Model_Question_Option();
				
				for ($i = 0; $i < $_POST['count_answers']; ++$i) {
					if (!$_POST['answer_' . ($i + 1)]) {
						continue;
					}
					
					$optionData = array(
						'text'		=> $_POST['answer_' . ($i + 1)],
						'correct'	=> $_POST['correct_answer_' . ($i + 1)] == '1' ? true : false,
						'question'	=> $question_id,
					);
					
					$option->insert($optionData);
				}
				
				$this->_helper->redirector('index', 'question');
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
		
		$question = new Application_Model_Question();
		
		$this->view->questions = $question->getUserQuestions($this->_userData['id']);
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
		
		$questionTable = new Application_Model_Question();
		$questionTable->remove($this->_getParam('id'), $this->_userData['id']);
		
		$this->_helper->redirector('index', 'question');
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
				'text'	=> $question['text'],
				'weight'=> $question['weight']
			));
		}
		
		$this->view->form = $form;
	}
}