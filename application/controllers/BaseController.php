<?php

class BaseController extends Zend_Controller_Action
{
	/**
	 * @var Zend_Session
	 */
	protected $_session;

	/**
	 * @var Application_Model_User
	 */
	protected $_user;
	
	/**
	 * @var Application_Model_Config
	 */
	protected $_config;

	/**
	 * @var array
	 */
	protected $_userData;

	/**
	 * @var bool
	 */
	protected $_loggedIn;

	function init()
	{
		$this->_session = Zend_Registry::get('session');
		$this->_user = new Application_Model_User;
		$this->_config = $this->view->config = new Application_Model_Config;

		if (intval($this->_session->userId)) {
			$this->_userData = $this->_user->getAdapter()->select('u.*, g.*')
			->from('user as u')
			->where('u.id = ?', $this->_session->userId)->query()->fetch();

			$this->_loggedIn = $this->view->loggedIn = true;
		} else {
			$this->_userData = array();
			$this->_loggedIn = $this->view->loggedIn = false;
			$this->view->login_form = new Application_Form_Login;
		}

		$this->view->userData = $this->_userData;
	}
}