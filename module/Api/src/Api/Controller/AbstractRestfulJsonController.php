<?php
namespace Api\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Http\Response;
use Utility\Registry;
use Zend\View\Model\JsonModel;

class AbstractRestfulJsonController extends AbstractRestfulController
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';

    /**
     * Initializer method for Registry
     */
    protected function _init()
    {
        Registry::setServiceManager($this->serviceLocator);
    }

    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
    }
    # Override default actions as they do not return valid JsonModels
    public function create($data)
    {
        return $this->methodNotAllowed();
    }
    public function delete($id)
    {
        return $this->methodNotAllowed();
    }
    public function deleteList()
    {
        return $this->methodNotAllowed();
    }
    public function get($id)
    {
        return $this->methodNotAllowed();
    }
    public function getList()
    {
        return $this->methodNotAllowed();
    }
    public function head($id = null)
    {
        return $this->methodNotAllowed();
    }
    public function options()
    {
        return $this->methodNotAllowed();
    }
    public function patch($id, $data)
    {
        return $this->methodNotAllowed();
    }
    public function replaceList($data)
    {
        return $this->methodNotAllowed();
    }
    public function patchList($data)
    {
        return $this->methodNotAllowed();
    }
    public function update($id, $data)
    {
        return $this->methodNotAllowed();
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