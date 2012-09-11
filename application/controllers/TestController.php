<?php

require_once 'BaseController.php';

class TestController extends BaseController
{
	/**
	 * Lista wszystkich testów
	 */
	public function indexAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$testTable = new Application_Model_Test();
		
		$this->view->tests = $testTable->getUserTests($this->_userData['id']);
	}
	
	/**
	 * Dodawanie nowego testu
	 */
	public function newAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$form = new Application_Form_Test_New;
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$testTable = new Application_Model_Test();
				$questionData = array();
				$questionData['open'] 				= $_POST['open'];
				$questionData['name'] 				= $_POST['name'];
				$questionData['description'] 		= $_POST['description'];
				$questionData['points'] 			= $_POST['points'];
				$questionData['3_5'] 				= $_POST['3_5'];
				$questionData['4'] 					= $_POST['4'];
				$questionData['4_5'] 				= $_POST['4_5'];
				$questionData['5'] 					= $_POST['5'];
				$questionData['start_at'] 			= $_POST['start_at'];
				$questionData['end_at'] 			= $_POST['end_at'];
				$questionData['time'] 				= $_POST['time'];
				$questionData['quastions_limit'] 	= $_POST['quastions_limit'];
				$questionData['one_page'] 			= $_POST['one_page'];
				$questionData['ip_mask'] 			= $_POST['ip_mask'];
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
	
	/**
	 * Edycja testu
	 */
	public function editAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
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
				$questionData['description'] 		= $_POST['description'];
				$questionData['points'] 			= $_POST['points'];
				$questionData['3_5'] 				= $_POST['3_5'];
				$questionData['4'] 					= $_POST['4'];
				$questionData['4_5'] 				= $_POST['4_5'];
				$questionData['5'] 					= $_POST['5'];
				$questionData['start_at'] 			= $_POST['start_at'];
				$questionData['end_at'] 			= $_POST['end_at'];
				$questionData['time'] 				= $_POST['time'];
				$questionData['quastions_limit'] 	= $_POST['quastions_limit'];
				$questionData['one_page'] 			= $_POST['one_page'];
				$questionData['ip_mask'] 			= $_POST['ip_mask'];
	
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
					'name'			=> $test['name'],
					'description'	=> $test['description'],
					'open'			=> $test['open'],
					'points'		=> $test['points'],
					'3_5'			=> $test['3_5'],
					'4'				=> $test['4'],
					'4_5'			=> $test['4_5'],
					'5'				=> $test['5'],
					'start_at'		=> $test['start_at'],
					'end_at'		=> $test['end_at'],
					'time'			=> $test['time'],
					'one_page'		=> $test['one_page'],
					'quastions_limit'	=> $test['quastions_limit'],
					'ip_mask'		=> $test['ip_mask'],
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
	
	/**
	 * Usuwanie testu
	 */
	public function removeAction()
	{
		$testTable = new Application_Model_Test();
		$testTable->delete('id = ' .$this->_getParam('id'));
		
		$this->_flashMessenger->setNamespace('success')->addMessage('Test został usunięty');
		$this->_helper->redirector('index', 'test');
	}
	
	/**
	 * Rozpoczynanie testu przez użytkownika
	 */
	public function startAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('register', 'user');
		}
		
		$testTable = new Application_Model_Test();
		$testUserTable = new Application_Model_User_Test();
		
		$test_id = $this->_getParam('id');
		
		// sprawdzam, czy użytkownik nie rozwiązywał tego testu
		$testUser = $testUserTable->select()
			->where('user = ?', $this->_userData['id'])
			->where('test = ?', $test_id)
			->query()->fetch();
		
		// szukam rekordu z testem mając jego ID
		$test = $testTable->find($test_id)->getRow(0)->toArray();
		
		// zabezpieczenie testu - tylko wybrane adresu IP
		if($test['ip_mask'] && $test['ip_mask'] != 'x.x.x.x') {
			$mask = explode('.', $test['ip_mask']);
			$ip = explode('.', $_SERVER['SERVER_ADDR']);
			
			for ($i = 0; $i < count($mask); ++$i) {
				if ($mask[$i] != 'x' && $ip[$i] != $mask[$i]) {
					
					$this->_flashMessenger->setNamespace('error')->addMessage('Twój numer IP nie pozwala na możliwość rozwiązania tego testu');
					$this->_helper->redirector('index', 'index');
				}
			}
			
		}
		
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

		// pobieram wszystkie kategorie pytań
		$categories = $testTable->getAdapter()->query('SELECT * FROM test_category as tc WHERE test = ' . $test['id'])->fetchAll();
		
		$ids = array();
		
		foreach ($categories as $cat) { // i zapisuję do tablicy ich identyfikatory
			$ids[] = $cat['category'];
		}
		
		$q = 'SELECT * FROM question as ques WHERE ques.category IN(' . implode(',', $ids) .')';
		
		$questions = $testTable->getAdapter()->query($q)->fetchAll();
		
		$count = $test['quastions_limit'] < count($questions) ? $test['quastions_limit'] : count($questions);
		
		// tutaj "mieszam" tablicą z pytaniami po to, żeby za chwilę wybrać losowe pytania do testu
		$list = array_flip(range(1, count($questions)));
		
		// tablica została już wymieszana (patrz wyżej), to mogę już spokojnie wybrać X pytań do testu
		$ids = array_rand($list, $count);
		
		$testUserId = $testUserTable->insert(array(
				'user'	=> $this->_userData['id'],
				'test'	=> $test_id,
				'started_at'	=> date('Y-m-d H:i:s'),
				'result'		=> 0,
				'current_question'	=> 1
		));
		
		// zapisuję do bazy danych wszystkie pytania, które zostały wylosowane
		foreach ($ids as $id) {
			$id = $questions[$id - 1]['id'];
			$q = "INSERT INTO user_test_question VALUES ($testUserId, $id)";
			
			$testTable->getAdapter()->query($q);
		}
		
		// i przekierowuję na pierwsze pytanie
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
			$_SESSION['time_left'] = 0;
			$testUserTable->update(array('finished' => true), 'id = ' . $testUser['id']);
			$this->_helper->redirector('index', 'index');
		}

		$timeLeft = (strtotime($startedAt->format('Y-m-d H:i:s')) - strtotime($now->format('Y-m-d H:i:s')) );

		$_SESSION['time_left'] = $timeLeft;

		$this->_helper->layout->setLayout('test'); // zmieniam szablon strony ze zmienionym lewym menu
		
		$form = new Zend_Form;
		
		if (!$test['one_page']) { // czyli pytania mają wyświetlaś się pojedyńczo: jedno pytanie - jedna strona
			$q2 = 'SELECT *, quest.id as quest_id FROM question as quest LEFT JOIN user_test_question as utq ON utq.question = quest.id WHERE user_test = ' . $testUser['id'];
			$questions = $questionTable->getAdapter()->query($q2)->fetchAll(); // pobieram wszystkie pytania
			$question = $questions[$testUser['current_question'] - 1];
						
			$q = 'SELECT * FROM question_option WHERE question = ' . $question['quest_id'];
			$options = $questionTable->getAdapter()->query($q)->fetchAll();
			
			$op = array();
			
			foreach ($options as $o) {
				$op[$o['id']]	= $o['text'];
			}
			
			$questionText = $question['text'];
			
			if ($question['file']) {
				$questionText .= '<br /><br /><img class="question-atachement" src="' . $this->view->url(array(
						'controller'	=> 'question',
						'action'		=> 'attachement',
						'id'			=> $question['question']
				)) .'"/ ><br /><br />';
			}
			
			// dodaję do formularza listę z checkboxami, w których są opcje odpowiedzi dla pytania
			$form->addElement('multiCheckbox', 'answer', array(
					'label'	=> $questionText,
		        	'required' => true,
					'extended'	=> true,
					'multiOptions'	=> $op,
		    ));
			
			$form->getElement('answer')->addDecorator('Label', array(
					'escape' => false
			));
			
			if (count($_POST)) { // jeśli formularz został wysłany
				if ($form->isValid($_POST)){	// i czy jest prawidłowy (czyli np została zaznaczona co najmniej jedna opcja)
					$data = $form->getValues();
					$points = 0;
					$correct = true;
					$correct_count = 0;
					
					// przeszukuje tablicę z opcjami odpowiedzi użytkownika i szukam te, które są prawidłowe
					foreach ($options as $o) {
						if (in_array($o['id'], $data['answer'])) {
							
							if (!$o['correct']) {
								$correct = false;
							}
							
							$answerData = array(
									'user_test'	=> $testUser['id'],
									'question'	=> $question['quest_id'],
									'answer'	=> $o['id'],
									'points'	=> $points
							);
								
							$answerTable->insert($answerData);
						} else {
							if ($o['correct']) {
								$correct = false;
							}
						}
						
					}
					
					if ($correct) {
						$points = $question['weight'];
					}
					
					$testData = array();
					
					if ($testUser['current_question'] == count($questions)) { // czyli użytkownik odpowiedział na ostatnie pytanie
						$testData['finished'] = true;
																		
						// suma puntków za poprawnie udzielone odpowiedzi
						$correct = 0;
						$all_sum = 0;
						
						$correct_part = true;
						
						$questions = $answerTable->getAdapter()
							->query("SELECT *, quest.id as quest_id FROM user_test_question as utq LEFT JOIN question as quest ON quest.id = utq.question WHERE user_test = " . $testUser['id'])
							->fetchAll();
						
						$questionsData = array();
						
						foreach ($questions as $question) {
							
							$correct_options = array();	// poprawne odpowiedzi do pytania
							$user_options = array();   // odpowiedzi udzielone przez użytkownika
							
							// pobieram wszystkie poprawne odpowiedzi do pytania
							$options = $answerTable->getAdapter()
								->query("SELECT * FROM question_option as qo WHERE correct = 1 AND question = " . $question['quest_id'])
								->fetchAll();
							
							// i zapisuję je do tablicy (same ID odpowiedzi)
							foreach ($options as $option) {
								$correct_options[] = $option['id'];
							}
							
							// następnie porównuje je z tymi, które udzielił użytkownik
							$options = $answerTable->getAdapter()
								->query("SELECT * FROM  user_test_answer as uta WHERE user_test = " . $testUser['id'] . ' AND question = ' . $question['quest_id'])
								->fetchAll();
							
							// zapisuję ID odpowiedzi użytkownika do tablicy
							foreach ($options as $option) {
								$user_options[] = $option['answer'];
							}
							
							if ($user_options == $correct_options) {
								$correct += $question['weight'];
							}
							
							$all_sum += $question['weight'];
						}
						
						// obliczam ile procent miał dobrych odpowiedzi
						$percent = round(($correct / $all_sum) * 100);
						
						$testData['result'] = $testUser['result'] + $percent;
						
						$testUserTable->update($testData, 'id = ' . $testUser['id']);
						$this->_flashMessenger->setNamespace('success')->addMessage('Test został ukończony. Twój wynik to: ' . $testData['result'] . ' %');
						$this->_helper->redirector('myresults', 'test');
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
		} else { // wszystkie pytania na jednej stronie
			$q2 = 'SELECT *, quest.id as quest_id FROM question as quest LEFT JOIN user_test_question as utq ON utq.question = quest.id WHERE user_test = ' . $testUser['id'];
			$questions = $questionTable->getAdapter()->query($q2)->fetchAll(); // pobieram wszystkie pytania
			
			$i = 0; // iterator
			
			foreach ($questions as $question) {
				$q = 'SELECT * FROM question_option WHERE question = ' . $question['quest_id'];
				$options = $questionTable->getAdapter()->query($q)->fetchAll();
					
				$op = array();
					
				foreach ($options as $o) {
					$op[$o['id']]	= $o['text'];
				}
				
				$questionText = $question['text'];
				
				if ($question['file']) {
				$questionText .= '<br /><br /><img class="question-atachement" src="' . $this->view->url(array(
						'controller'	=> 'question',
						'action'		=> 'attachement',
						'id'			=> $question['question']
				)) .'"/ ><br /><br />';
				}
					
				$form->addElement('multiCheckbox', 'answer_' . $question['id'], array(
						'label'	=> $questionText,
						'required' => true,
						'multiOptions'	=> $op
				));
				
				$form->getElement('answer_' . $question['id'])->addDecorator('Label', array(
						'escape' => false
				));
			}
			
			if (count($_POST)) {// formularz został wysłany
				if ($form->isValid($_POST)){ // i jest prawidłowy
					$sum_points = $correct_points = 0;
					
					$data = $form->getValues();
			
					/**
					 * Tutaj przechodzę po wszystkich pytaniach w teście
					 * Następnie pobieram listę wszystkich poprawnych odpowiedzi dla pytania i porównuję je z tymi podanymi przez użytkownika
					 */
					foreach ($data as $quest => $ans) {
						$quest = explode('_', $quest);
						
						if (count($quest) != 2) {
							continue;
						}
						
						$q = 'SELECT * FROM question_option WHERE question = ' . $quest[1];
						$options = $questionTable->getAdapter()->query($q)->fetchAll();
						
						$correct = true;
						$correct_count = 0;
						
						$datasToInsert = array();
												
						foreach ($options as $o) {
							$points = 0;
							
							if (in_array($o['id'], $ans)) {
									
								if (!$o['correct']) {
									$correct = false;
								}
								
								$datasToInsert[] = array(
										'user_test'	=> $testUser['id'],
										'question'	=> $quest[1],
										'answer'	=> $o['id'],
								);
									
							} else {
								if ($o['correct']) {
									$correct = false;
								}
							}
							
						}
							
						if ($correct) {
							$points = $question['weight'];
						}
						
						$q = 'SELECT * FROM question WHERE id = ' . $quest[1];
						$q = $questionTable->getAdapter()->query($q)->fetch();
							
						if ($correct) {
							$correct_points += $q['weight'];
						}
						
						$sum_points += $q['weight'];
						
						foreach ($datasToInsert as $insert) {
							if ($correct) {
								$insert['points'] = $question['weight'];
							}
							
							$answerTable->insert($insert);
						}						
					}
					
					// obliczam procent dobrych odpowiedzi
					$percent = number_format(($correct_points / $sum_points) * 100, 2);
					
					// zapisuję wynik
					$data = array(
							'finished'	=> true,
							'result'	=> $percent
					);
					
					$testUserTable->update($data, 'id = ' . $testUser['id']);
					
					$this->_flashMessenger->setNamespace('success')->addMessage('Test został ukończony. Twój wynik to: ' . $percent . ' %');
					$this->_helper->redirector('myresults', 'test');
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
	
	/**
	 * Statystyki
	 */
	function groupsAction()
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
					'not_passed'=> count($allUsers) - $passed,
					'questions'	=> array(),
					'users'		=> array(),
			);
			
			// statystyki per pytanie
			
			$questions = $userTestTable->getAdapter()
				->query('SELECT * FROM question as quest LEFT JOIN `test_category` as tg ON tg.category = quest.category WHERE tg.test = ' . $test_id)
				->fetchAll();
			
			$questionsData = array();
			
			foreach ($questions as $question) {
				$data = $userTestTable->getAdapter()
					->query('SELECT * FROM user_test_answer as uta LEFT JOIN user_test as ta ON ta.id = uta.user_test LEFT JOIN question_option as ans ON ans.id = uta.answer WHERE test =' . $test_id )
					->fetchAll();
				
				$correct = 0;
				
				foreach ($data as $d) {
					if ($d['correct']) {
						++$correct;
					}
				}
				
				if (!isset($questionsData[$question['id']])) {
					$questionsData[$question['id']] = array(
							'text'	=> $question['text'],
							'correct'	=> $correct,
							'incorrect'	=> count($data) - $correct,
							'id'		=> $question['id'],
					);
				} else {
					$questionsData[$question['id']]['correct'] += $correct;
					$questionsData[$question['id']]['incorrect'] += count($data) - $correct;
				}
			}
			
			$groups[$i]['stats']['questions'] = $questionsData;
			
			// statystyki per user
			$users = $userTestTable->getAdapter()
				->query('SELECT *, u.id as user_id, ut.id as user_test_id FROM user_test as ut LEFT JOIN user as u ON u.id = ut.user WHERE ut.test = ' . $test_id)
				->fetchAll();
			
			$usersData = array();
			
			foreach ($users as $user) {
				$answers = $userTestTable->getAdapter()
					->query('SELECT *, quest.text as question_text, qo.text as answer_text FROM user_test as ut LEFT JOIN  user_test_answer as uta ON uta.user_test = ut.id LEFT JOIN question as quest ON quest.id = uta.question LEFT JOIN question_option as qo ON qo.id = uta.answer WHERE ut.test=' . $test_id . ' AND ut.user = ' . $user['user_id'])
					->fetchAll();
				
				$answersData = array();
				
				foreach ($answers as $ans) {
					$answersData[] = array(
							'text'		=> $ans['question_text'],
							'weight'	=> $ans['weight'],
							'correct'	=> $ans['correct'],
							'answer_text' => $ans['answer_text'],
					);
				}
				
				$usersData[] = array(
						'name'		=> $user['name'],
						'result'	=> $user['result'],
						'answers'	=> $answersData,
						'user_test_id'	=> $user['user_test_id']
				);
			}
			
			$groups[$i]['stats']['users'] = $usersData;
		}
		
		$test = $testTable->find($test_id)->getRow(0)->toArray();
		
		$this->view->groups = $groups;
		$this->view->test = $test;
	}
	
	function linksAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		if ($this->_config->getConfig('site/type') == 'closed') {
			if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
				$this->_helper->redirector('index', 'index');
			}
		}
		
		$id = $this->_getParam('id');
		$groupTable = new Application_Model_Group;
		$request = Zend_Controller_Front::getInstance()->getRequest();
		
		$result = array();
		$groups = $groupTable->getUserGroups($this->_userData['id']);
		
		foreach ($groups as $group) {
			$result[] = array(
					'name'	=> $group['name'],
					'link'	=> $request->getScheme() . '://' . $request->getHttpHost() . $this->view->url(array(
							'controller'	=> 'user',
							'action'		=> 'register',
							'code'			=> base64_encode($id . '-' . $group['id'])
					), 'default')
			);
		}
		
		echo json_encode($result);
		
		die;
	}
	
	/**
	 * Wyniki testów użytkownika
	 */
	function myresultsAction()
	{
		if (!$this->_loggedIn) {
			$this->_helper->redirector('index', 'index');
		}
		
		$userTestTable = new Application_Model_User_Test;
		
		$this->view->tests = $userTestTable->getTests($this->_userData['id']);
	}
	
	function myresultstestAction()
	{
		$testUserId = $this->_getParam('test');
		$result = array();
		
		$userTestTable = new Application_Model_User_Test;
		$userTestAnswerTable = new Application_Model_User_Test_Answer;
		$questionOptionTable = new Application_Model_Question_Option;
		
		$questions = $userTestTable->getQuestionsInTest($testUserId);
		
		foreach ($questions as $question) {
			$questionData = array(
					'text'	=> $question['text'],
					'correct' => array(),
					'answers' => array(),
			);
			
			$corrects = $questionOptionTable->getOnlyCorrectOptions($question['question']);
			
			foreach ($corrects as $correct) {
				$questionData['correct'][] = $correct['text'];
			}
			
			$answers = $userTestAnswerTable->getAnswers($testUserId, $question['question']);
							
			foreach ($answers as $correct) {
				$questionData['answers'][] = $correct['text'];
			}
			
			$questionData['ok'] = $correct == $answers;
									
			$result[] = $questionData;
		}
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		
		die(json_encode($result));
	}
}
