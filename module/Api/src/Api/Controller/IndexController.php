<?php
namespace Api\Controller;
use Utility\Registry;
use Zend\View\Model\JsonModel;
use \User\Repository\User as UserRepository;

/**
 * Class IndexController
 * @package Api\Controller
 * REST API Root for /api/, /api/authenticate and /api/release-authentication calls
 */
class IndexController extends AbstractRestfulJsonController
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';

    /**
     * Initializer method for Registry
     *
     * @return IndexController
     */
    protected function _init()
    {
        Registry::setServiceManager($this->serviceLocator);
        return $this;
    }

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

    /**
     * Check that $_SERVER['REQUEST_METHOD'] is what we expect, otherwise set statusCode to 405 and return error message.
     *
     * param string $expectedMethod
     * @return bool|JsonModel
     */
    protected function validateRequestMethod($expectedMethod)
    {
        if($_SERVER['REQUEST_METHOD'] != $expectedMethod)
        {
            $this->response->setStatusCode(405);
            return new JsonModel(array('Message' => 'Method Not Allowed, please use ' . $expectedMethod));
        }
        return true;
    }

    /**
     * Get Json request data from PHP input stream
     *
     * @return mixed
     */
    protected function getJsonRequest()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}