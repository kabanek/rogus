<?php

class Application_Form_Login extends Zend_Form {
    function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'email', array(
            'label' => 'Adres email',
            'required' => false
        ));

        $this->addElement('password', 'password', array(
            'label' => 'Hasło',
            'required' => true
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Zaloguj',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}