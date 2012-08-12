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
				$questionData['one_page'] 			= $_POST['one_page'];
				$questionData['user'] 				= $this->_userData['id'];
								
				$test_id = $testTable->insert($questionData);
				$testCategoryTable = new Application_Model_Test_Category;
				
				foreach ($_POST['categories'] as $cat_id) {
					$testCategoryTable->insert(array(
							'test'		=> $test_id,
							'category'	=> $cat_id,
					));
				}
				
				$testGroupTable = new Application_Model_Test_Group;
				
				foreach ($_POST['groups'] as $cat_id) {
					$testGroupTable->insert(array(
							'test'		=> $test_id,
							'group'		=> $cat_id,
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
		
		$test_id = $this->_getParam('id');
		
		$test = $testTable->find($test_id)->getRow(0)->toArray();
	
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
				$questionData['one_page'] 			= $_POST['one_page'];
	
				$testTable->update($questionData, 'id = ' . $this->_getParam('id'));
				$testCategoryTable = new Application_Model_Test_Category;
				$testGroupTable = new Application_Model_Test_Group;
				
				$query = 'DELETE FROM test_category WHERE test = ' . $test_id;

				$testCategoryTable->getAdapter()->query($query);
	
				foreach ($_POST['categories'] as $cat_id) {
					$testCategoryTable->insert(array(
							'test'		=> $test_id,
							'category'	=> $cat_id,
					));
				}
				
				$query = 'DELETE FROM test_group WHERE test = ' . $test_id;
				
				$testGroupTable->getAdapter()->query($query);
				
				foreach ($_POST['groups'] as $cat_id) {
					$testGroupTable->insert(array(
							'test'		=> $test_id,
							'group'		=> $cat_id,
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
			
			$testCategoryTable = new Application_Model_Test_Category;
			$cats = $testCategoryTable->getAdapter()->query('SELECT category FROM test_category WHERE test = ' . $test_id)->fetchAll();
			
			$ids = array();
			
			foreach ($cats as $cat) {
				$ids[] = $cat['category'];
			}
			
			$form->getElement('categories')->setValue($ids);
			
			$testGroupTable = new Application_Model_Test_Group;
			$cats = $testCategoryTable->getAdapter()->query('SELECT `group` FROM test_group WHERE test = ' . $test_id)->fetchAll();
				
			$ids = array();
				
			foreach ($cats as $cat) {
				$ids[] = $cat['group'];
			}
				
			$form->getElement('groups')->setValue($ids);
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
	
	public function startAction()
	{
		$testTable = new Application_Model_Test();
		$testUserTable = new Application_Model_User_Test();
		
		$test_id = $this->_getParam('id');
		
		// sprawdzam, czy użytkownik nie rozwiązywał tego testu
		$testUser = $testUserTable->select()
			->where('user = ?', $this->_userData['id'])
			->where('test = ?', $test_id)
			->query()->fetch();
		
		$test = $testTable->find($test_id)->getRow(0)->toArray();
		
		// sprawdzam, czy data rozpoczęcia testu pozwala na jego rozwiązywanie
		$now	   = new DateTime;
		$startedAt = new DateTime($test['start_at']);
		
		if ($now < $startedAt) {
			$this->_flashMessenger->setNamespace('success')->addMessage('Nie można rozwiązywać testu');
			$this->_helper->redirector('index', 'index');
		}
		
		$startedAt = new DateTime($test['end_at']);
		
		if ($now > $startedAt) {
			$this->_flashMessenger->setNamespace('success')->addMessage('Czas na rozwiązanie testu minął');
			$this->_helper->redirector('index', 'index');
		}
		
		if ($testUser) {
			$this->_flashMessenger->setNamespace('success')->addMessage('Test został już rozpoczęty');
			$this->_helper->redirector('question', 'test','default', array(
					'id'	=> $test_id
			));
		}
				
		$categories = $testTable->getAdapter()->query('SELECT * FROM test_category as tc WHERE test = ' . $test['id'])->fetchAll();
		
		$ids = array();
		
		foreach ($categories as $cat) {
			$ids[] = $cat['category'];
		}
		
		$q = 'SELECT * FROM question as ques WHERE ques.category IN(' . implode(',', $ids) .')';
		
		$questions = $testTable->getAdapter()->query($q)->fetchAll();
		
		$count = $test['quastions_limit'] < count($questions) ? $test['quastions_limit'] : count($questions);
		
		$list = array_flip(range(1, count($questions)));
		
		$ids = array_rand($list, $count);
		
		$testUserId = $testUserTable->insert(array(
				'user'	=> $this->_userData['id'],
				'test'	=> $test_id,
				'started_at'	=> date('Y-m-d H:i:s'),
				'result'		=> 0,
				'current_question'	=> 1
		));
		
		foreach ($ids as $id) {
			$id = $questions[$id - 1]['id'];
			$q = "INSERT INTO user_test_question VALUES ($testUserId, $id)";
			
			$testTable->getAdapter()->query($q);
		}
		
		$this->_flashMessenger->setNamespace('success')->addMessage('Test został rozpoczęty');
		$this->_helper->redirector('question', 'test','default', array(
					'id'	=> $test_id
		));
	}
	
	public function questionAction()
	{
		$testTable = new Application_Model_Test();
		$questionTable = new Application_Model_Question();
		$testUserTable = new Application_Model_User_Test();
		$answerTable = new Application_Model_User_Test_Answer();
		
		$test_id = $this->_getParam('id');
		
		// sprawdzam, czy użytkownik nie rozwiązywał tego testu
		$testUser = $testUserTable->select()
			->where('user = ?', $this->_userData['id'])
			->where('test = ?', $test_id)
			->query()->fetch();
		
		$test = $testTable->find($test_id)->getRow(0)->toArray();
		
		if (!$testUser) {
			$this->_flashMessenger->setNamespace('success')->addMessage('Nie jesteś zapisany do tego testu');
			$this->_helper->redirector('index', 'index');
		}
		
		// czy test nie został już wcześniej zakończony?
		if ($testUser['finished']) {
			$this->_flashMessenger->setNamespace('success')->addMessage('Test został już ukończony');
			$this->_helper->redirector('index', 'index');
		}
		
		// sprawdzam, czy upłynął limit czasu na odpowiedź
		$startedAt = new DateTime($testUser['started_at']);
		$now	   = new DateTime;
		
		$startedAt->modify('+' . $test['time'] . ' minutes');
		
		if ($startedAt < $now) {
			$this->_flashMessenger->setNamespace('success')->addMessage('Upłynął wyznaczony czas');
			$testUserTable->update(array('finished' => true), 'id = ' . $testUser['id']);
			$this->_helper->redirector('index', 'index');
		}
		
		$form = new Zend_Form;
		
		if (!$test['one_page']) {
			$q2 = 'SELECT *, quest.id as quest_id FROM question as quest LEFT JOIN user_test_question as utq ON utq.question = quest.id WHERE user_test = ' . $testUser['id'];
			$questions = $questionTable->getAdapter()->query($q2)->fetchAll(); // pobieram wszystkie pytania
			$question = $questions[$testUser['current_question'] - 1];
						
			$q = 'SELECT * FROM question_option WHERE question = ' . $question['quest_id'];
			$options = $questionTable->getAdapter()->query($q)->fetchAll();
			
			$op = array();
			
			foreach ($options as $o) {
				$op[$o['id']]	= $o['text'];
			}
			
			$form->addElement('select', 'answer', array(
					'label'	=> $question['text'],
		        	'required' => true,
					'multiOptions'	=> $op
		    ));
			
			if (count($_POST)) {
				if ($form->isValid($_POST)){
					$data = $form->getValues();
					$points = 0;
					
					foreach ($options as $o) {
						if ($data['answer'] == $o['id']) {
							
							if ($o['correct']) {
								$points = 1;
							}
							
							break;
						}
					}
					
					$answerData = array(
							'user_test'	=> $testUser['id'],
							'question'	=> $question['quest_id'],
							'answer'	=> $data['answer'],
							'points'	=> $points
					);
					
					$answerTable->insert($answerData);
					
					$testData = array();
					
					if ($testUser['current_question'] == count($questions)) {
						$testData['finished'] = true;
						
						// zliczam ilość poprawnych odpowiedzi
						$answers = $answerTable->getAdapter()
							->query("SELECT * FROM user_test_answer as uta LEFT JOIN question as quest ON quest.id = uta.question")
							->fetchAll();
												
						// ilość poprawnie udzielonych odpowiedzi
						$correct = 0;
						
						foreach ($answers as $answer) {
							$options = $answerTable->getAdapter()
								->query("SELECT * FROM question_option WHERE question = " . $answer['question'])
								->fetchAll();
							
							foreach ($options as $option) {
								if ($option['id'] == $answer['answer']) {
									
									if ($option['correct']) {
										++$correct;
									}
									
									break;
								}
							}
						}
						
						$testData['result'] = round($correct / count($answers), 2) * 100;
						
						$testUserTable->update($testData, 'id = ' . $testUser['id']);
						$this->_flashMessenger->setNamespace('success')->addMessage('Test roztał ukończony');
						$this->_helper->redirector('index', 'index');
					} else {
						$testData['current_question'] = $testUser['current_question'] + 1;
					}
					
					$testUserTable->update($testData, 'id = ' . $testUser['id']);
					
					$this->_flashMessenger->setNamespace('success')->addMessage('Świetnie! Teraz odpowiedz na kolejne pytanie');
					$this->_helper->redirector('question', 'test','default', array(
								'id'	=> $test_id
					));
				}
			}
		}
		
		$form->addElement('submit', 'submit', array(
				'label'	=> 'Wyślij odpowiedz'
		));
		
		$this->view->test = $test;
		
		$this->view->form = $form;
	}
	
	function resultsAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		if ($this->_config->getConfig('site/type') == 'closed') {
			if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
				$this->_helper->redirector('index', 'index');
			}
		}
		
		$answerTable = new Application_Model_User_Test_Answer();
		
		$tests = $answerTable->getAdapter()
			->query('SELECT * FROM user_test as ut LEFT JOIN test as t ON t.id = ut.test WHERE ut.user = ' . $this->_userData['id'])
			->fetchAll();
		
		$this->view->tests = $tests;
	}
	
	function groupsAction()
	{
		$testTable = new Application_Model_Test();
		$userTestTable = new Application_Model_User_Test();
		
		$test_id = $this->_getParam('id');
		
		$test = $testTable->find($test_id)->getRow(0)->toArray();
		
		$groups = $userTestTable->getAdapter()
			->query('SELECT * FROM test_group as tg LEFT JOIN `group` as gr ON gr.id = tg.group WHERE test = ' . $test_id)
			->fetchAll();
		
		for($i = 0; $i < count($groups); ++$i) {
			$allUsers = $userTestTable->getAdapter()
				->query('SELECT * FROM user as u LEFT JOIN user_group as ug ON ug.user = u.id LEFT JOIN test_group as tg ON tg.`group` = ug.`group` LEFT JOIN user_test as ut ON ut.test = tg.test WHERE ug.`group` = ' . $groups[$i]['id'])
				->fetchAll();
						
			$passed = 0;
			
			foreach ($allUsers as $user) {
				if ($user['result'] >= $test['points']) {
					++$passed;
				}
			}
			
			$groups[$i]['stats'] = array(
					'passed'	=> $passed,
					'not_passed'=> count($allUsers) - $passed
			);
			
			$questions = $userTestTable->getAdapter()
				->query('SELECT * FROM question as quest LEFT JOIN `test_category` as tg ON tg.category = quest.category WHERE tg.test = ' . $test_id)
				->fetchAll();
			
			// statystyki per pytanie
		}
		
		$test = $testTable->find($test_id);
		
		$this->view->groups = $groups;
		$this->view->test = $test;
	}
}
