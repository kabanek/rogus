<?php

class Application_Form_User_Remember extends Zend_Form {
    function init()
    {
        $this->setMethod('post');
        
        $this->addElement('text', 'email', array(
            'label' => 'Adres email',
            'required' => true
        ));

        $this->addElement('text', 'indeks', array(
            'label' => 'Numer indeksu (jeśli posiadasz)',
            'required' => false
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Wyślij nowe hasło',
        ));
    }
}