<?php 
namespace Principal\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class AddPyme extends Form {

	public function __construct($name = NULL){
		parent::__construct($name);
		$this->setAttribute('method', 'post');
			

			
		$this->add(array(
				'name' => 'nombre',
				'options' => array(
						'label' => 'Empresa',
				),
				'attributes' => array(
						'type' => 'text',
						'placeholder' => 'Tu Empresa',
						'class' => 'input'
				),
		));
			
			
		$this->add(array(
				'type' => 'Zend\Form\Element\Email',
				'name' => 'email',
				'options' => array(
						'label' => 'Email'
				),
				'attributes' => array(
						'placeholder' => 'you@domain.com'
				)
		));
			
		$this->add(array(
				'type' => 'textarea',
				'name' => 'servicios',
				'options' => array(
						'label' => 'Servicios'

				),
				'attributes' => array(
						'placeholder'=>'Que ofrece tu empresa',
						'rows'=>'10'
				)
		));
			
		$this->add(array(
				'type' => 'submit',
				'name' => 'send',
				'attributes' => array(
						'value'=>'Publicar'
				)
		));
		$this->add(array(
				'type' => 'file',
				'name' => 'file',
				'attributes'=> array(
						'id'=>'file'
				),
		));
			
			
			
		//* Campo tipo password

		$this->add(array(
				'name' => 'password',
				'options' => array(
						'label' => 'Empresa',
				),
				'attributes' => array(
						'type' => 'password',
						'placeholder' => 'password',
						'class' => 'input'
				),
		));
			
		$paquete = new Element\Radio('paquete');
		$paquete->setLabel("Paquete:");
		$paquete->setValueOptions(
				array(
						'0'=>'Gratuito :: $0.00',
						'1'=>utf8_encode('Básico :: $50.00 Mensual'),
						'2'=>'Estandard :: $300.00 Mensual',
						'3'=>'Premium :: $589.00 Mensual'
				)
		);
		$this->add($paquete);
			
		$ciudad = new Element\Select('ciudad');
		$ciudad->setLabel("Ciudad:");
		$ciudad->setEmptyOption('Seleccione la ciudad...');
		$ciudad->setValueOptions(
				array(
						'Xalapa'=>'Xalapa',
						'Veracruz'=>'Veracruz',
						'Actopan'=>'Actopan',
						'Coatzacoalcos'=>'Coatzacoalcos'
				)
		);
		$this->add($ciudad);
			
	}
}

