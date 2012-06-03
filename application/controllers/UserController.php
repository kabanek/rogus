<?php

require_once 'BaseController.php';

class UserController extends BaseController
{
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
					$this->_helper->redirector('index', 'index');
				} else {
					$this->_helper->redirector('login', 'user');
				}
			}
		}

		$this->view->no_login_form = true;
		$this->view->form = $form;
	}

	public function logoutAction()
	{
		unset($this->_session->userId);
		$this->_helper->redirector('index', 'index');
	}
}