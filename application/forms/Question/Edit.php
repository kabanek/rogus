<?php

class Application_Form_Question_Edit extends Zend_Form {
	
	protected $_categories;
	
	public function __construct(array $categories = array())
	{
		$this->_categories = $categories;
		parent::__construct();
	}
		
    function init()
    {
        $this->setMethod('post');

        $this->addElement('textarea', 'text', array(
            'label' => 'Treść pytania',
            'required' => true,
        	'cols'		=> 60,
        	'rows'		=> 4
       ));
        
        $this->addElement('text', 'weight', array(
        		'required' => true,
        		'value'		=> '10',
        		'label'		=> 'Ilość punktów za pytanie'
        ));
        
        $this->addElement('select', 'category', array(
        		'required' => true,
        		'label'		=> 'Kategoria',
        		'multiOptions'	=> $this->_categories
        ));
                
        $this->addElement('file', 'file', array(
        		'label' => 'Załącznik',
        		'required' => false
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Edytuj',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}