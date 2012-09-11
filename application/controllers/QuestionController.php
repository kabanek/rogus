<?php

require_once 'BaseController.php';

class QuestionController extends BaseController
{
	/**
	 * Nowe pytanie
	 */
	public function newAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$categoryTable = new Application_Model_Question_Category();
		
		$categories = array();
		
		foreach ($categoryTable->getUserCategories($this->_userData['id']) as $category) {
			$categories[$category['id']] = $category['name'];
		}
		
		$form = new Application_Form_Question_New($categories);
				
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$question = new Application_Model_Question();
				$questionData = array();
				$questionData['text'] 		= $_POST['text'];
				$questionData['weight'] 	= $_POST['weight'];
				$questionData['user'] 		= $this->_userData['id'];
				$questionData['category'] 	= $_POST['category'];
				
				if (isset($_FILES['file']) && count($_FILES['file'])) {
					$file_name = uniqid('question_');
					move_uploaded_file($_FILES['file']['tmp_name'], BASE_PATH . '/data/' . $file_name);
					
					$questionData['file'] = $file_name;
					$questionData['file_mime'] = mime_content_type($_FILES['file']['tmp_name']);
					$questionData['file_name'] = $_FILES['file']['name'];
				}
				
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
				
				$this->_flashMessenger->setNamespace('success')->addMessage('Pytanie zostało dodane');
				
				$this->_helper->redirector('index', 'question');
			}
		}
		
		$this->view->form = $form;
	}
	
	/**
	 * Lista pytań
	 */
	public function indexAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$question = new Application_Model_Question();
		
		$this->view->questions = $question->getUserQuestions($this->_userData['id']);
	}
	
	/**
	 * Usuwanie
	 */
	public function removeAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$questionTable = new Application_Model_Question();
		$questionTable->remove($this->_getParam('id'), $this->_userData['id']);
		
		$this->_flashMessenger->setNamespace('success')->addMessage('Pytanie zostało usunięte');
		
		$this->_helper->redirector('index', 'question');
	}
	
	/**
	 * Edycja
	 */
	public function editAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$questionTable = new Application_Model_Question;
		$question = $questionTable->get($this->_getParam('id'), $this->_userData['id']);
		
		if (!$question) {
			$this->_helper->redirector('index', 'question');
		}
		
		$questionOptionTable = new Application_Model_Question_Option;
		
		$options = $questionOptionTable->getByQuestion($this->_getParam('id'));
		
		$categoryTable = new Application_Model_Question_Category();
		
		$categories = array();
		
		foreach ($categoryTable->getUserCategories($this->_userData['id']) as $category) {
			$categories[$category['id']] = $category['name'];
		}
		
		$form = new Application_Form_Question_Edit($categories, count($options));
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$data = array(
						'text' 		=> $_POST['text'],
						'weight' 	=> $_POST['weight'],
						'category'	=> $_POST['category'],
				);
				
				if (isset($_FILES['file']) && count($_FILES['file'])) {
					$file_name = uniqid('question_');
					move_uploaded_file($_FILES['file']['tmp_name'], BASE_PATH . '/data/' . $file_name);
						
					$data['file'] = $file_name;
					$data['file_mime'] = mime_content_type($_FILES['file']['tmp_name']);
					$data['file_name'] = $_FILES['file']['name'];
				}
				
				$questionTable->update($data, 'id = ' . $this->_getParam('id'));
				
				$questionOptionTable->deleteAllOptions($this->_getParam('id'));
				
				for ($i = 0; $i < $_POST['count_answers']; ++$i) {
					if (!$_POST['answer_' . ($i + 1)]) {
						continue;
					}
					
					$optionData = array(
							'text'		=> $_POST['answer_' . ($i + 1)],
							'correct'	=> $_POST['correct_answer_' . ($i + 1)] == '1' ? true : false,
							'question'	=> $this->_getParam('id'),
					);
						
					$questionOptionTable->insert($optionData);
				}
				
				$this->_flashMessenger->setNamespace('success')->addMessage('Pytanie zostało zaktualizowane');
				
				$this->_helper->redirector('index', 'question');
			}
		} else {
			$form->setDefaults(array(
				'text'	=> $question['text'],
				'weight'=> $question['weight'],
				'category'=> $question['category']
			));
			
			$i = 1;
			foreach ($options as $option) {
				$form->setDefaults(array(
						'answer_' . $i			=> $option['text'],
						'correct_answer_' . $i 	=> $option['correct'],
				));
				
				++$i;
			}
		}
		
		$this->view->form = $form;
	}
	
	/**
	 * Pobieranie załącznika
	 */
	public function attachementAction()
	{
		$questionTable = new Application_Model_Question;
		$question = $questionTable->get($this->_getParam('id'), $this->_userData['id']);
		
		if ($question['file']) {
			
			header('Content-type: ' . $question['file_mime']);
			
			// The PDF source is in original.pdf
			readfile(BASE_PATH . '/data/' . $question['file']);
			die;
		}
		
		die;
	}
}
