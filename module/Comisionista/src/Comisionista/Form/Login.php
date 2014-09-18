<?php
namespace Comisionista\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class Login extends Form {

	public function __construct($name = NULL){
		parent::__construct($name);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-signin');
		$this->setAttribute('role', 'form');

		$this->add(array(
				'name'=>'username',
				'options' => array(
						'label' => 'Usuario ',
				),
				'attributes'=>array(
						'type'=>'text',
						'placeholder' => 'usuario',
						'class' => 'form-control',
						'required'=>'true'
				),

		));
		$this->add(array(
				'name'=>'password',
				'options' => array(
						'label' =>utf8_encode('Contraseña ').' ',
				),
				'attributes'=>array(
						'type'=>'password',
						'placeholder' => utf8_encode('contraseña'),
						'class' => 'form-control',
						'required'=>'true'
				),

		));
			$this->add(array(
				'name'=>'email',
				'options' => array(
						'label' =>utf8_encode('Correo Electrónico ').' ',
				),
				'attributes'=>array(
						'type'=>'email',
						'placeholder' => utf8_encode('Correo Electrónico'),
						'class' => 'form-control',
						'required'=>'true'
				),

		));
		$this->add(array(
				'name'=>'send',
				'attributes'=>array(
						'type'=>'submit',
						'value'=>'Entrar',
						'class' => 'btn btn-lg btn-primary btn-block'
				),
		
		));
	}
}
