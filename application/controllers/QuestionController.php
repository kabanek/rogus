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
		
		$question = new Application_Model_Question();
		$question->remove($this->_getParam('id'), $this->_userData['id']);
		
		$this->_helper->redirector('index', 'question');
	}
}
