<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
'controllers' => array(
		'invokables' => array(
				'Empresa\Controller\Index' => 'Empresa\Controller\IndexController',
				'Empresa\Controller\Veracruz' => 'Empresa\Controller\VeracruzController',
				'Empresa\Controller\Formulario' => 'Empresa\Controller\FormularioController',
				
		),
),
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'empresa' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/veracruz',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Empresa\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:url][-p:id2][.html][/:controller][_:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' 		 => '[0-9]*',
                                'id'         => '[0-9]*',
                                'url'		 => '[a-zA-Z][a-zA-Z0-9-]*',
                            ),
                            'defaults' => array(
                            /*
                            '__NAMESPACE__' => 'Application\Controller',
                            'controller'    => 'Empresa',
                            'action'        => 'index',
                           */
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_EN',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/index'           => __DIR__ . '/../view/layout/index.phtml',
            'veracruz/index/index' => __DIR__ . '/../view/veracruz/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'veracruz'=>__DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
