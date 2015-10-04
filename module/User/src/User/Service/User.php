<?php
namespace User\Service;

use Utility\Registry;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Session\SessionManager;

class User implements UserServiceInterface
{

    /**
     * Authenticate user.
     * @param string $username
     * @param string $password
     * @return AuthenticationResponse
     */
    public function authenticate($username, $password)
    {
        $em = Registry::getEntityManager();

        //Get User and validate password
        $user = $em->getRepository('\User\Entity\User')
                   ->findOneBy(array('username' => $username));

        if (is_null($user) || !$user->passwordValid($password))
        {
            // Return failure response
            return new AuthenticationResponse('Failure', 'Could not authenticate user');
        }

        // Init SessionManager, save user data for use later
        $sessionManager = new SessionManager();
        $sessionManager->start();
        $userData = $user->getUserDataForRegistry($sessionManager->getId());
        Registry::setUserData($userData);

        // Return success response
        return new AuthenticationResponse('Success', 'User authenticated', $userData);
    }

    /**
     * Release user authentication. (This will destroy existing session data)
     * @param $token
     * @return AuthenticationResponse
     */
    public function releaseAuthentication($token)
    {
        // Init SessionManager, set session id
        $sessionManager = new SessionManager();
        $sessionManager->setId($token);
        $sessionManager->start();

        // Destroy session
        $sessionManager->destroy();

        // Return success response
        return new AuthenticationResponse('Success', 'User authentication released');
    }
}

class AuthenticationResponse
{
    public $status;
    public $message;
    public $userData;

    function __construct($status, $message, $userData = array())
    {
        $this->status = $status;
        $this->message = $message;
        $this->userData = $userData;
    }

    public function toArray()
    {
        return array(
            'status' => $this->status,
            'message' => $this->message,
            'userData' => $this->userData
        );
    }
}