<?php
namespace User\Repository;

use Utility\Registry;

class Users
{
    /**
     * User authentication proxy method
     * @param string $username
     * @param string $password
     * @return array
     */
    public static function authenticate($username, $password)
    {
        $service = Registry::getServiceManager()->get('User.Service.User');
        return $service->authenticate($username, $password)->toArray();
    }

    /**
     * User release authentication proxy method
     * @param string $token
     * @return array
     */
    public static function releaseAuthentication($token)
    {
        $service = Registry::getServiceManager()->get('User.Service.User');
        return $service->releaseAuthentication($token)->toArray();
    }
}