<?php

require_once 'BaseController.php';

class ConfigController extends BaseController
{
	function indexAction()
	{
		$configTable = new Application_Model_Config;
		
		$this->view->configs = $configTable->select()->query()->fetchAll();
	}
	
	function editAction()
	{
		$id = $this->_getParam('id');
		
		$configTable = new Application_Model_Config;
		
		$this->view->configs = $configTable->select()->where('id = ?', $id)->query()->fetch();
		
		if (count($_POST)) {
			$upadate = array('value' => $_POST['value']);
			
			$configTable->update($upadate, 'id = ' . $id);
			
			$this->_flashMessenger->setNamespace('success')->addMessage('Zachowane');
			$this->_helper->redirector('index', 'config');
		}
	}
}