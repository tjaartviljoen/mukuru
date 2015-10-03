<?php
return array(
    'router' => array(
        'routes' => array(
            'rest-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/',
                    'defaults' => array(
                        'controller' => 'Api\Controller\Index',
                    ),
                ),
            ),
            'authenticate' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/authenticate',
                    'defaults' => array(
                        'controller' => 'Api\Controller\Index',
                        'action'     => 'authenticate'
                    ),
                ),
            ),
            'release-authentication' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/release-authentication',
                    'defaults' => array(
                        'controller' => 'Api\Controller\Index',
                        'action'     => 'release-authentication'
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Api\Controller\Index' => 'Api\Controller\IndexController',

        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);