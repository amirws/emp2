<?php
/**
 * Created by JetBrains PhpStorm.
 * User: martin
 * Date: 6/09/13
 * Time: 1:47
 * To change this template use File | Settings | File Templates.
 */

namespace Micrositio\Form;

use Zend\Validator;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\I18n\Validator as I18nValidator;

class LoginValidator extends InputFilter{

    public function __construct(){

        /* email filters and validators */

        $usuario = new Input('username');
        $usuario->setRequired(true);

        // Filters
        $usuario->getFilterChain()
               ->attachByName('StripTags')
               ->attachByName('StringTrim');

        // Validators
        $usuario->getValidatorChain()
                 ->attach(new Validator\NotEmpty());

        $this->add($usuario);

        /* clave filters and validators */

        $clave = new Input('password');
        $clave->setRequired(true);

        // Filters
        $clave->getFilterChain()
              ->attachByName('StripTags')
              ->attachByName('StringTrim');

        // Validators
        $clave->getValidatorChain()
            ->attach(new Validator\StringLength(array('min' => 4, 'max' => 14,
                'messages' => array(
                    Validator\StringLength::TOO_SHORT => "La clave debe tener mÃ­nimo 6 caracteres",
                    Validator\StringLength::TOO_LONG => "La clave debe tener mÃ¡ximo 14 caracteres"))))
            ->attach(new I18nValidator\Alnum(array('allowWhiteSpace' => false)));

        $this->add($clave);

    }


}