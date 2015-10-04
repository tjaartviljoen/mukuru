<?php
namespace Api\Controller;
use Zend\View\Model\JsonModel;
use \User\Repository\Users as UserRepository;

/**
 * Class IndexController
 * @package Api\Controller
 * REST API Root for /api/, /api/authenticate and /api/release-authentication calls
 */
class IndexController extends AbstractRestfulJsonController
{


    /**
     * Index method, used to display welcome message and instructions.
     *
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(array('data' => "Welcome to the Mukuru API, please call /api/authenticate to continue"));
    }

    /**
     * Authenticate user, parameter input is RAW.
     *
     * @return bool|JsonModel
     */
    public function authenticateAction()
    {
        $this->_init();

        // Make sure request method is POST, send 405 if not.
        $validatedRequestMethod = $this->validateRequestMethod(IndexController::METHOD_POST);
        if(true !== $validatedRequestMethod)
        {
            return $validatedRequestMethod;
        }

        // Get JSON parameters
        $request = $this->getJsonRequest();

        // Authenticate
        return new JsonModel(UserRepository::authenticate($request['username'], $request['password']));
    }

    public function getUserDataAction()
    {
        $this->_init();

        // Make sure request method is POST, send 405 if not.
        $validatedRequestMethod = $this->validateRequestMethod(IndexController::METHOD_POST);
        if(true !== $validatedRequestMethod)
        {
            return $validatedRequestMethod;
        }

        // Get JSON parameters
        $request = $this->getJsonRequest();

        // Authenticate
        return new JsonModel(UserRepository::getUserData($request['token']));
    }

    /**
     * Release user authentication.
     * Parameter  - php://input {"username":[username],"password":[password]}.
     *
     * @return bool|JsonModel
     */
    public function releaseAuthenticationAction()
    {
        $this->_init();

        // Make sure request method is POST, send 405 if not.
        $validatedRequestMethod = $this->validateRequestMethod(IndexController::METHOD_POST);
        if(true !== $validatedRequestMethod)
        {
            return $validatedRequestMethod;
        }

        // Get JSON parameters
        $request = $this->getJsonRequest();

        return new JsonModel(UserRepository::releaseAuthentication($request['token']));
    }
}