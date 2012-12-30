<?php

require_once 'BaseController.php';

class GroupController extends BaseController
{
	function indexAction()
	{
		$groupTable = new Application_Model_Group;

		$order = isset($_GET['order']) ?  $_GET['order']: 'id';
		$type = isset($_GET['type']) ?  $_GET['type']: 'ASC';
		
		$this->view->groups = $groupTable->getUserGroups($this->_userData['id'], $order, $type);
	}
	
	function newAction()
	{
		$form = new Application_Form_Group_New;
		$groupTable = new Application_Model_Group;
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$data = array(
						'name'	=> $_POST['name'],
						'user'	=> $this->_userData['id'],
				);
				
				$groupTable->insert($data);
				
				$this->_flashMessenger->setNamespace('success')->addMessage('Grupa została dodana');
				$this->_helper->redirector('index', 'group');
			}
		}
		
		$this->view->form = $form;
	}
	
	function editAction()
	{
		$form = new Application_Form_Group_New;
		$groupTable = new Application_Model_Group;
		
		$group = $groupTable->find($this->_getParam('id'))->getRow(0)->toArray();
		
		if (count($_POST)) {
			if ($form->isValid($_POST)) {
				$data = array(
						'name'	=> $_POST['name'],
						'user'	=> $this->_userData['id'],
				);
		
				$groupTable->update($data, 'id = ' . $group['id']);
		
				$this->_flashMessenger->setNamespace('success')->addMessage('Grupa została zaktualizowana');
				$this->_helper->redirector('index', 'group');
			}
		} else {
			$form->setDefault('name', $group['name']);
		}
		
		$this->view->form = $form;
	}
	
	public function removeAction()
	{
		$groupTable = new Application_Model_Group;
		$groupTable->delete('id = ' . $this->_getParam('id'));
		
		$this->_flashMessenger->setNamespace('success')->addMessage('Grupa została usunięta');
		$this->_helper->redirector('index', 'group');
	}
}