<?php
namespace User\Service;

use Utility\Registry;
use Zend\Session\SessionManager;

class User implements UserServiceInterface
{

    /**
     * @param String $username
     * @param String $password
     * @return AuthenticationResponse
     */
    public function authenticate(String $username, String $password)
    {
        $em = Registry::getEntityManager();
        $response = new AuthenticationResponse();

        /**
         * @var \User\Entity\User
         */
        $user = $em->getRepository('\User\Entity\User')
                   ->findOneBy(array('username' => $username));

        if (is_null($user) || !$user->passwordValid($password))
        {
            $response->status = 'Failure';
            $response->message = 'Could not authenticate user';
            $response->userData = null;
            return $response;
        }

        $sessionManager = new SessionManager();
        $userData = $user->getUserDataForRegistry($sessionManager->getId());
        Registry::setUserData($userData);

        $response->status = 'Success';
        $response->message = 'User authenticated';
        $response->userData = $userData;
        return $response;
    }

    public function releaseAuthentication(String $token)
    {
        // TODO: Implement releaseAuthentication() method.
    }

}

class AuthenticationResponse
{
    public $status;
    public $message;
    public $userData;
}