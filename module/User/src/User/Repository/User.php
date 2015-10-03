<?php
namespace User\Repository;

use Utility\Registry;

class User
{
    /**
     * User authentication proxy method
     * @param string $username
     * @param string $password
     * @return \User\Service\AuthenticationResponse
     */
    public static function authenticate($username, $password)
    {
        $service = Registry::getServiceManager()->get('User.Service.User');
        return $service->authenticate($username, $password);
    }

    /**
     * User release authentication proxy method
     * @param string $token
     * @return \User\Service\AuthenticationResponse
     */
    public static function releaseAuthentication($token)
    {
        $service = Registry::getServiceManager()->get('User.Service.User');
        return $service->releaseAuthentication($token);
    }
}