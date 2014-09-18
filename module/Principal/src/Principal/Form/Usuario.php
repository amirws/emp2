<?php
namespace Principal\Form;

use Zend\Form\Annotation\Required;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class Usuario extends Form {

	public function __construct($name = NULL){
		parent::__construct($name);
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name'=>"nombre",
				'options'=>array(
						'label'=>"Nombre Completo"
						),
				'attributes'=>array(
						'type'=>'text',
						'placeholder' => 'Nombre Completo',
						'class' => 'input'
						),
				
				));
		$this->add(array(
				'name'=>"email",
				'options'=>array(
						'label'=>utf8_encode('Correo Electr�nico'),
						
				),
				'attributes'=>array(
						'type'=>'email',
						'placeholder' => utf8_encode('Correo Electr�nico'),
						'class' => 'input',
						'id' => 'email',
						'required'=>'true'
				),
		
		));
		$this->add(array(
				'name'=>"password",
				'options'=>array(
						'label'=>utf8_encode('Contrase�a')
				),
				'attributes'=>array(
						'type'=>'password',
						'placeholder' => utf8_encode('Contrase�a'),
						'class' => 'input',
						'id' => 'password',
						'required'=>'true'
				),
		
		));
		$this->add(array(
				'name'=>"repeatPassword",
				'options'=>array(
						'label'=>utf8_encode('Repite Contrase�a')
				),
				'attributes'=>array(
						'type'=>'password',
						'placeholder' => utf8_encode('Repite Contrase�a'),
						'class' => 'input',
						'id' => 'repeatPassword',
						'required'=>'true'
				),
		
		));
		
		
		$this->add (new Element\Button('security'));
		$this->add(array(
				'name'=>'send',
				'attributes'=>array(
				'type'=>'submit',
				'value'=>'REGISTRARME',
				'class'=>'btn btn-sm btn-primary btn-block'
				),
				));
	}
}