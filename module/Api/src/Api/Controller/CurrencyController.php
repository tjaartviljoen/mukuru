<?php
namespace Api\Controller;

use Currency\Repository\Currencies;
use Utility\Registry;
use Zend\View\Model\JsonModel;

/**
 * Class CurrencyController
 * @package Api\Controller
 * REST API for /api/currencies/v1 calls
 */
class CurrencyController extends AbstractRestfulJsonController
{
    /**
     * Get a list of currencies.
     *
     * @return JsonModel
     */
    public function getList()
    {
        $this->_init();

        // Check for token
        $token = $this->params()->fromQuery('token', 'get');
        if(null == $token)
        {
            $this->response->setStatusCode(400);
            return new JsonModel(array('data' => "You have pass a token with this API call"));
        }

        // Check if user is authenticated
        Registry::restoreSession($token);
        if(!Registry::isAuthenticated())
        {
            $this->response->setStatusCode(412);
            return new JsonModel(array('data' => "You have to be authenticated to use this api"));
        }

        // Get currencies
        return new JsonModel(Currencies::getList());
    }

    /**
     * Get a currency record.
     *
     * @param int $id
     * @return JsonModel
     */
    public function get($id)
    {
        $this->_init();

        // Check for token
        $token = $this->params()->fromQuery('token', 'get');
        if(null == $token)
        {
            $this->response->setStatusCode(400);
            return new JsonModel(array('data' => "You have pass a token with this API call"));
        }

        // Check if user is authenticated
        Registry::restoreSession($token);
        if(!Registry::isAuthenticated())
        {
            $this->response->setStatusCode(412);
            return new JsonModel(array('data' => "You have to be authenticated to use this api"));
        }

        // Get currency record
        return new JsonModel(Currencies::get($id));
    }
}