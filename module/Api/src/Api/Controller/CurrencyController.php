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
     * Index method, used to display welcome message and instructions.
     *
     * @return JsonModel
     */
    public function getList()
    {
        $this->_init();
        $token = $this->params()->fromQuery('token', 'get');
        if(null == $token)
        {
            return new JsonModel(array('data' => "You have pass a token with this API call"));
        }

        Registry::restoreSession($token);

        if(!Registry::isAuthenticated())
        {
            return new JsonModel(array('data' => "You have to be authenticated to use this api"));
        }

        return new JsonModel(Currencies::getList());
    }

    public function get($id)
    {
        $this->_init();
        $token = $this->params()->fromQuery('token', 'get');
        if(null == $token)
        {
            return new JsonModel(array('data' => "You have pass a token with this API call"));
        }

        Registry::restoreSession($token);

        if(!Registry::isAuthenticated())
        {
            return new JsonModel(array('data' => "You have to be authenticated to use this api"));
        }

        return new JsonModel(Currencies::get($id));
    }
}