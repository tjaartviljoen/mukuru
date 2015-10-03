<?php
return array(
    'router'       => array(
        'routes' => array(
            'rest-home'                        => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api',
                    'defaults' => array(
                        'controller' => 'Api\Controller\Index',
                    ),
                ),
            ),
            'rest-user-authenticate'           => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/users/v1/authenticate',
                    'defaults' => array(
                        'controller' => 'Api\Controller\Index',
                        'action'     => 'authenticate'
                    ),
                ),
            ),
            'rest-user-release-authentication' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/users/v1/release-authentication',
                    'defaults' => array(
                        'controller' => 'Api\Controller\Index',
                        'action'     => 'release-authentication'
                    ),
                ),
            ),
            'rest-currencies'                  => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/currencies/v1',
                    'defaults' => array(
                        'controller' => 'Api\Controller\Currency',
                    ),
                ),
            ),
        ),
    ),
    'controllers'  => array(
        'invokables' => array(
            'Api\Controller\Index'    => 'Api\Controller\IndexController',
            'Api\Controller\Currency' => 'Api\Controller\CurrencyController',

        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);