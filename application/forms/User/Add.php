<?php

class Application_Form_User_Add extends Zend_Form {
    function init()
    {
        $this->setMethod('post');
        
        $this->addElement('text', 'name', array(
                'label' => 'Imię i nazwisko',
                'required' => true,
        ));

        $this->addElement('text', 'email', array(
            'label' => 'Adres email',
            'required' => true
       ));

        $this->getElement('email')
            ->addValidator('Db_NoRecordExists', true, array('table' => 'user', 'field' => 'email'));

        $this->addElement('password', 'password', array(
            'label' => 'Nowe',
            'required' => true
       ));
        $this->addElement('password', 'password2', array(
                'label' => 'Powtórz nowe',
                'required' => true
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
                'label'         => 'Grupy',
                'required'      => false,
                'multiple'      => true,
                'multiOptions'  => $catsSelect
        ));
        
        $this->getElement('groups')->setRegisterInArrayValidator(false);
        
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