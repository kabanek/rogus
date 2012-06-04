<?php

class Application_Form_Question_New extends Zend_Form {
	
	protected $_count_answers;
	
	protected $_categories;
	
	public function __construct(array $categories = array(), $count_answers = 5)
	{
		$this->_count_answers = $count_answers;
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
        
        for ($i = 0; $i < $this->_count_answers; ++$i) {
        	$this->addElement('text', 'answer_' . ($i + 1), array(
        			'label' => 'Odpowiedź nr ' . ($i + 1),
        			'required' => $i < 2 ? true : false
        	));
        	
        	$this->addElement('checkbox', 'correct_answer_' . ($i + 1), array(
        			'label' => 'Czy odpowiedź nr ' . ($i + 1) . ' jest prawidłową odpowiedzią?',
        	));
        }
        
        $this->addElement('hidden', 'count_answers', array(
        		'required' => true,
        		'value'		=> $this->_count_answers
        ));
        
        $this->addElement('file', 'file', array(
        		'label' => 'Załącznik',
        		'required' => false
        ));

        $this->addElement('submit', 'submit', array(
            'label' => 'Dodaj',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}