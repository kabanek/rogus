<?php

class Application_Form_Category_New extends Zend_Form {
		
    function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'name', array(
            'label' => 'Nazwa kategorii',
            'required' => true,
       ));
        
        $this->addElement('submit', 'submit', array(
            'label' => 'Dodaj',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}