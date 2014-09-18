<?php

namespace Empresa\Form;
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class Search extends Form{
	public function __construct($name = NULL){
		parent::__construct($name);
		$this->setAttribute('method', 'post');
		
		$this->add(array(
				'name' => 'search',
				'options' => array(
						'label' => '',
				),
				'attributes' => array(
						'type' => 'text',
						'placeholder' => 'Restaurantes',
						'class' => 'input'
				),
		));
			
 }
}

?>