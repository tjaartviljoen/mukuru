<?php
namespace Utility;
use Zend\Session\SessionManager;

/**
 * Registry class for statically available Service Manager & Doctrine Entity Manager.
 */
class Registry
{

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    static protected $sm = null;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    static protected $em;

    /**
     * User data for authentication purposes
     * @var array
     */
    static protected $userData = array();

    /**
     * @var \Zend\Session\Container
     */
    static protected $session;

    /**
     * Set Zend Service Manager & Doctrine Entity Manager for easy access.
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sm
     * @return boolean
     */
    static public function setServiceManager($sm)
    {
        self::$sm = $sm;
        self::$em = self::$sm->get('doctrine.entitymanager.orm_default');
        return true;
    }

    /**
     * Retrieve Zend Service Manager.
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    static public function getServiceManager()
    {
        return self::$sm;
    }

    /**
     * Retrieve Doctrine Entity Manager.
     * @return \Doctrine\ORM\EntityManager
     */
    static public function getEntityManager()
    {
        return self::$em;
    }

    /**
     * Initiate session container.
     */
    static protected function initSession()
    {
        is_null(self::$session) && self::$session = new \Zend\Session\Container(__CLASS__);
    }

    /**
     * Clear grid data stored in session.
     * @return boolean
     */
    static public function clearSession()
    {
        self::initSession();
        if (isset(self::$session->userData))
        {
            unset(self::$session->userData);
        }
        return true;
    }

    /**
     * Set user authentication data in registry and session
     * @param array $userData
     */
    static public function setUserData(array $userData)
    {
        self::initSession();
        self::$userData = $userData;
        self::$session->userData = $userData;
    }

    /**
     * Retrieve user authentication data.
     * @return array
     */
    static public function getUserSessionData()
    {
        self::initSession();

        if(!empty(self::$userData))
        {
            return self::$userData;
        }

        if(isset(self::$session->userData))
        {
            self::$userData = self::$session->userData;
            return self::$userData;
        }

        return array();
    }

    public static function restoreSession($token)
    {
        $sessionManager = new SessionManager();
        $sessionManager->setId($token);
        $sessionManager->start();
    }

    /**
     * Check if we have authentication data.
     * @return boolean
     */
    static public function isAuthenticated()
    {
        self::initSession();
        return isset(self::$session->userData);
    }
}