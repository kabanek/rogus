<?php

class Application_Form_Test_New extends Zend_Form {
		
    function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'name', array(
            'label' => 'Nazwa testu',
            'required' => true,
       	));
        
        $this->addElement('select', 'open', array(
        		'label' => 'Czy test ma być ogólnodostępny',
        		'required' => true,
        		'multiOptions'	=> array(
        			'0'	=> 'Nie',
        			'1'	=> 'Tak'
        		)
        ));
        
        $this->addElement('text', 'points', array(
        		'label' => 'Od ilu procent test jest zaliczony pozytywnie (w %)',
        		'required' => true,
        		'value'	=> 50
        ));
        
        $this->addElement('text', 'start_at', array(
        		'label' => 'Czas rozpoczęcia testu',
        		'required' => true,
        		'value'	=> date('Y-m-d H:i:s')
        ));
        
        $this->addElement('text', 'end_at', array(
        		'label' => 'Czas zakończenia testu',
        		'required' => true,
        		'value'	=> date('Y-m-d H:i:s')
        ));
        
        $session = Zend_Registry::get('session');
        
        $categoryTable = new Application_Model_Question_Category();
        $cats = $categoryTable->getUserCategories($session->userId);
        
        $catsSelect = array();
        
        foreach ($cats as $cat) {
        	$catsSelect[$cat['id']] = $cat['name'];
        }
        
        $this->addElement('select', 'categories', array(
        		'label' 		=> 'Kategorie pytań',
        		'required' 		=> true,
        		'multiple'		=> true,
        		'multiOptions'	=> $catsSelect
        ));
        
        $this->getElement('categories')->setRegisterInArrayValidator(false);
        
        $testTable = new Application_Model_Group();
        $cats = $testTable->getUserGroups($session->userId);
        
        $catsSelect = array();
        
        foreach ($cats as $cat) {
        	$catsSelect[$cat['id']] = $cat['name'];
        }
        
        $this->addElement('select', 'groups', array(
        		'label' 		=> 'Grupy użytkowników',
        		'required' 		=> true,
        		'multiple'		=> true,
        		'multiOptions'	=> $catsSelect
        ));
        
        $this->getElement('groups')->setRegisterInArrayValidator(false);
        
        $this->addElement('text', 'time', array(
        		'label' => 'Długość trwania testu (w minutach)',
        		'required' => true,
        		'value'	=> 15
        ));
        
        $this->addElement('text', 'quastions_limit', array(
        		'label' => 'Ilość pytań do wylosowania',
        		'required' => true,
        		'value'	=> 10
        ));
        
        $this->addElement('submit', 'submit', array(
        		'label' => 'Zapisz',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}