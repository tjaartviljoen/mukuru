<?php
namespace Api;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                //__NAMESPACE__ . '.Service.User' => __NAMESPACE__ . '\Service\User',
            )
        );
    }
}