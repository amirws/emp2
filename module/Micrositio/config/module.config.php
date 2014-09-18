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
				'Micrositio\Controller\Html' => 'Micrositio\Controller\HtmlController',
                'Facebook\Controller\Facebook' => 'Facebook\Controller\FacebookController',
                'Facebook\Controller\BaseFacebook' => 'Facebook\Controller\BaseFacebookController',
                'Micrositio\Controller\Usuario' => 'Micrositio\Controller\UsuarioController',
                'Micrositio\Controller\Newpyme' => 'Micrositio\Controller\NewpymeController'
		),
),
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'micrositio' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Micrositio\Controller',
                        'controller'    => 'Html',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[:pagina][_:action][.:controller][_:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9-]*',
                                'pagina'     => '[a-zA-Z][a-zA-Z0-9-]*'
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
        'locale' => 'es_ES',
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
            'micrositio/index/index' => __DIR__ . '/../view/micrositio/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'micrositio'=>__DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
