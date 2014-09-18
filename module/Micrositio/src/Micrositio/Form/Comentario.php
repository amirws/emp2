<?php

namespace Micrositio\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;
class Comentario extends Form{
	public function __construct($name = NULL){
		parent::__construct($name);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-signin');
		
		$this->add(array(
				'name' => 'usuario',
				'options' => array(
						'label' => '',
				),
				'attributes' => array(
						'type' => 'text',
						'class' => 'search-query'
				),
		));

		$valor = new Element\Radio('valor');
		$valor->setLabel("Valoración:");
		$valor->setValueOptions(
				array(
						'1'=>'1',
						'2'=>'2',
						'3'=>'3',
						'4'=>'4',
						'5'=>'5',
						'6'=>'6',
						'7'=>'7',
						'8'=>'8',
						'9'=>'9',
						'10'=>'10'
				)
		);
		$this->add($valor);
	
 }
}

?>