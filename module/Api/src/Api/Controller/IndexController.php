<?php
namespace Api\Controller;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulJsonController
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';

    public function getList()
    {
        return new JsonModel(array('data' => "Welcome to the Mukuru API, please call /api/authenticate to continue"));
    }

    public function authenticateAction()
    {
        $validatedRequestMethod = $this->_validateRequestMethod(IndexController::METHOD_POST);

        if(true !== $validatedRequestMethod)
        {
            return $validatedRequestMethod;
        }
        return new JsonModel(\User\Repository\User::authenticate($_POST['username'], $_POST['password']));
    }

    public function releaseAuthenticationAction()
    {
        $this->_validateRequestMethod(SELF::METHOD_POST);
        return new JsonModel(array('data' => "Authentication released"));
    }

    protected function _validateRequestMethod($expectedMethod)
    {
        if($_SERVER['REQUEST_METHOD'] != $expectedMethod)
        {
            $this->response->setStatusCode(405);
            return new JsonModel(array('Message' => 'Method Not Allowed, please use ' . $expectedMethod));
        }
        return true;
    }

    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
    }
}