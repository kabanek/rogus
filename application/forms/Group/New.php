<?php

class Application_Form_Group_New extends Zend_Form {
    function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'name', array(
            'label' => 'Nazwa grupy',
            'required' => false
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Zatwierdź',
        ));
    }
}