<?php

class Application_Form_Register extends Zend_Form {
    function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'name', array(
        		'label' => 'Nazwa użytkownika',
        		'required' => true,
        		'validators' => array(
        				array('StringLength', false, array(2, 50)),
        				array('Db_NoRecordExists', false, array(
        						'table' => 'user',
        						'field' => 'name'
        				))
        		)
       ));
        
        $this->getElement('name')
        	->setAttrib('required', 'required');
                
        $this->addElement('text', 'email', array(
            'label' => 'Adres email',
            'required' => true,
        		'validators' => array(
        				array('StringLength', false, array(2, 50)),
        				array('Db_NoRecordExists', false, array(
        						'table' => 'user',
        						'field' => 'email'
        				))
        		)
       ));
        
        $this->getElement('email')->addValidator('EmailAddress')
        	->setAttrib('required name', 'email');

        $this->addElement('password', 'password', array(
            'label' => 'Hasło',
            'required' => true
       ));
        
        $this->getElement('password')
        	->setAttrib('required', 'required');
        
        $this->addElement('password', 'password2', array(
        		'label' => 'Powtórz hasło',
        		'required' => true
       ));
        
        $this->getElement('password2')
        	->setAttrib('required', 'required')
        	->addValidator(new Zend_Validate_Identical('password'));

        $this->addElement('submit', 'submit', array(
            'label' => 'Zarejestruj',
        ));
    }
}