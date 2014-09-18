<?php

namespace Principal\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;
class Search extends Form{
	public function __construct($name = NULL){
		parent::__construct($name);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-signin');
		
		$this->add(array(
				'name' => 'search',
				'options' => array(
						'label' => '',
				),
				'attributes' => array(
						'type' => 'text',
						'placeholder' => 'Ejem: Restaurantes',
						'class' => 'search-query'
				),
		));
		
		$this->add(array(
				'name' => 'ciudad',
				'options' => array(
						'label' => '',
				),
				'attributes' => array(
						'type' => 'text',
						'placeholder' => 'Ejem: Xalapa',
						'class' => 'search-query'
				),
		));
		
		$ciudad = new Element\Select('ciudad2');
		$ciudad->setLabel("Ciudad:");
		$ciudad->setAttribute('class', 'search-query');

		$this->add($ciudad);
			
 }
}

?>