<?php

require_once 'BaseController.php';

class GroupController extends BaseController
{
    function indexAction()
    {
        if (!$this->_loggedIn) {
            $this->_helper->redirector('index', 'index');
        }
        
        if ($this->_config->getConfig('site/type') == 'closed') {
            if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
                $this->_helper->redirector('index', 'index');
            }
        }

        $groupTable = new Application_Model_Group;

        $this->view->groups = $groupTable->getUserGroups($this->_userData['id']);
    }

    function newAction()
    {
        if (!$this->_loggedIn) {
            $this->_helper->redirector('index', 'index');
        }
        
        if ($this->_config->getConfig('site/type') == 'closed') {
            if ($this->_userData['creditals'] != 1 && $this->_userData['admin'] != 1) {
                $this->_helper->redirector('index', 'index');
            }
        }

        $form = new Application_Form_Group_New;

        if (count($_POST)) {
            if ($form->isValid($_POST)) {
                $groupTable = new Application_Model_Group;

                $data = array();
                $data['name'] = $_POST['name'];
                $data['user'] = $this->_userData['id'];

                $groupTable->insert($data);

                $this->_flashMessenger->setNamespace('success')->addMessage('Grupa została grupa');
                $this->_helper->redirector('index', 'group');
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

        $group_id = intval($this->_getParam('id'));
        $groupTable = new Application_Model_Group;
        $group = $groupTable->find($group_id)->getRow(0)->toArray();

        $form = new Application_Form_Group_New;

        if (count($_POST)) {
            if ($form->isValid($_POST)) {
                $data = array(
                    'name'  => $_POST['name']
                );

                $groupTable->update($data, 'id = ' . $group_id);

                $this->_flashMessenger->setNamespace('success')->addMessage('Grupa została zachowana');
                $this->_helper->redirector('index', 'group');
            }
        } else {
            $form->setDefault('name', $group['name']);
        }

        $this->view->form = $form;
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

        $groupTable = new Application_Model_Group;

        $group_id = intval($this->_getParam('id'));

        $groupTable->delete('id = ' . $group_id);

        $this->_flashMessenger->setNamespace('success')->addMessage('Grupa została usunięta!');
        $this->_helper->redirector('index', 'group');
    }
}