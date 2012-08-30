<?php

class Application_Form_User_Edit extends Zend_Form {
    function init()
    {
        $this->setMethod('post');
        
        $this->addElement('text', 'name', array(
        		'label' => 'Imię i nazwisko',
        		'required' => true,
        ));

        $this->addElement('text', 'email', array(
            'label' => 'Adres email',
        		'readonly' => true,
            'required' => true
       ));

        $this->addElement('password', 'password', array(
            'label' => 'Nowe hasło (jeśli zmienić)',
            'required' => false
       ));
        $this->addElement('password', 'password2', array(
        		'label' => 'Powtórz nowe hasło',
        		'required' => false
       ));
        
        $this->getElement('password2')
	        ->addValidator(new Zend_Validate_Identical('password'));
        
        $session = Zend_Registry::get('session');
        
        $groupTable = new Application_Model_Group();
        $cats = $groupTable->fetchAll();
        
        $catsSelect = array();
        
        foreach ($cats as $cat) {
        	$catsSelect[$cat['id']] = $cat['name'];
        }
        
        $this->addElement('select', 'groups', array(
        		'label' 		=> 'Grupy',
        		'required' 		=> true,
        		'multiple'		=> true,
        		'multiOptions'	=> $catsSelect
        ));
        
        $this->getElement('groups')->setRegisterInArrayValidator(false);
        
        $session = Zend_Registry::get('session');
        
        if ($session->userData['admin']) {
	        $this->addElement('select', 'creditals', array(
	            'label' => 'Uprawnienia',
	            'required' => true,
	        	'multiOptions'	=> array(
	        			'0'	=> 'Uczeń',
	        			'1'	=> 'Nauczyciel'
	        	)
	       ));
	        
	        $this->addElement('checkbox', 'admin', array(
	        		'label' => 'Uprawnienia administratora',
	        		'required' => true,
	        ));
        }

        $this->addElement('submit', 'submit', array(
            'label' => 'Zapisz',
        ));
    }
}