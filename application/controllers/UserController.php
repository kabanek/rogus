<?php

require_once 'BaseController.php';

class UserController extends BaseController
{
	/**
	 * Logowanie
	 */
	public function loginAction()
	{
		$form = new Application_Form_Login;

		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$user = new Application_Model_User;
				$user->email = $_POST['email'];
				$user->password = $_POST['password'];

				$result = Zend_Auth::getInstance()->authenticate($user);

				if ($result->isValid()) {
					$this->_session->userId = $result->getIdentity();
					$this->_flashMessenger->setNamespace('success')->addMessage('Zostałeś zalogowany');
					$this->_helper->redirector('index', 'index');
				} else {
					$this->_flashMessenger->setNamespace('error')->addMessage('Zły login i/lub hasło');
					$this->_helper->redirector('login', 'user');
				}
			}
		}

		$this->view->no_login_form = true;
		$this->view->form = $form;
	}

	/**
	 * Wylogowanie usera
	 */
	public function logoutAction()
	{
		unset($this->_session->userId);
		$this->_flashMessenger->setNamespace('success')->addMessage('Zostałeś wylogowany');
		$this->_helper->redirector('index', 'index');
	}
	
	/**
	 * Formularz rejestracji
	 */
	public function registerAction()
	{
		$form = new Application_Form_Register;
		
		$request = $this->getRequest();
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$data = $_POST;
				unset($data['submit'], $data['password2']);
				$data['creditals'] = 0;
				
				$data['password'] = md5($data['password']);
				
				$userTable = new Application_Model_User;
				$userTable->insert($data);
				
				$this->_flashMessenger->setNamespace('success')->addMessage('Twoje konto zostało założone. Możesz się teraz zalogować');
				$this->_helper->redirector('index', 'index');
			}
		}
		
		$this->view->form = $form;
	}
	
	/**
	 * Użytkownicy
	 */
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
		
		$userTable = new Application_Model_User;
		
		$this->view->users = $userTable->fetchAll();
	}
	
	/**
	 * Edycja usera
	 */
	public function editAction()
	{
		$userTable = new Application_Model_User;
		
		$user_id = $this->_getParam('id');
		$user = $userTable->find($user_id)->getRow(0)->toArray();
		
		$form = new Application_Form_User_Edit;
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$values = $form->getValues();
				
				$data = array(
						'name'	=> $values['name'],
				);
				
				if ($values['password']) {
					if ($values['password'] != $values['password2']) {
						$this->_flashMessenger->setNamespace('error')->addMessage('Podane hasła różnią się od siebie');
						$this->_helper->redirector('edit', 'user', 'default', array(
								'id'	=> $user_id
						));
					}
					
					$data['password'] = md5($values['password']);
				}
				
				
				$userTable->update($data, 'id = ' . $user_id);
				
				$userGroupTable = new Application_Model_User_Group;
				
				$userGroupTable->delete('user = ' . $user_id);
				
				foreach ($values['groups'] as $group_id) {
					$data = array(
							'user'	=> $user_id,
							'group'	=> $group_id
					);
					
					$userGroupTable->insert($data);
				}
				
				$this->_flashMessenger->setNamespace('success')->addMessage('Użytkownik został edytowany');
				$this->_helper->redirector('index', 'user');
			}
		} else {
			$userGroupTable = new Application_Model_User_Group;
			
			$groups = $userGroupTable->getUserGroups($this->_userData['id']);
			
			$groupIds = array();
			
			foreach ($groups as $group) {
				$groupIds[] = $group['group'];
			}
			
			$form->setDefaults(array(
					'name'	=> $user['name'],
					'email'	=> $user['email'],
					'groups'=> $groupIds
			));
		}
		
		$this->view->form = $form;
	}
	
	/**
	 * usuwanie
	 */
	function removeAction()
	{
		$userTable = new Application_Model_User;
		
		$user_id = $this->_getParam('id');
		
		$userTable->delete('id = ' . $user_id);
		
		$this->_flashMessenger->setNamespace('success')->addMessage('Użytkownik został usunięty');
		$this->_helper->redirector('index', 'user');
	}
}