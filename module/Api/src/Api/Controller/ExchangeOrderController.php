<?php
namespace Api\Controller;

use ExchangeOrder\Repository\ExchangeOrders;
use Utility\Registry;
use Zend\View\Model\JsonModel;

/**
 * Class ExchangeOrderController
 * @package Api\Controller
 * REST API for /api/exchange-orders/v1 calls
 */
class ExchangeOrderController extends AbstractRestfulJsonController
{
    protected $createParametersRequired = array('token', 'currencyId', 'userId', 'foreignCurrencyAmount', 'localCurrencyAmount');

    /**
     * Get a list of currencies.
     *
     * @return JsonModel
     */
    public function getList()
    {
        $this->_init();

        // Check for token.
        $token = $this->params()->fromQuery('token');
        if (null == $token)
        {
            $this->response->setStatusCode(400);
            return new JsonModel(array('data' => "You have pass a token with this API call"));
        }

        // Check if user is authenticated.
        Registry::restoreSession($token);
        if (!Registry::isAuthenticated())
        {
            $this->response->setStatusCode(412);
            return new JsonModel(array('data' => "You have to be authenticated to use this api"));
        }

        // Get exchange orders.
        return new JsonModel(ExchangeOrders::getList());
    }

    /**
     * Get an exchange order record.
     *
     * @param int $id
     * @return JsonModel
     */
    public function get($id)
    {
        $this->_init();

        // Check for token.
        $token = $this->params()->fromQuery('token');
        if (null == $token)
        {
            $this->response->setStatusCode(400);
            return new JsonModel(array('data' => "You have pass a token with this API call"));
        }

        // Check if user is authenticated.
        Registry::restoreSession($token);
        if (!Registry::isAuthenticated())
        {
            $this->response->setStatusCode(412);
            return new JsonModel(array('data' => "You have to be authenticated to use this api"));
        }

        // Get currency record.
        return new JsonModel(ExchangeOrders::get($id));
    }

    public function create($data)
    {
        $this->_init();

        // Check for token.
        $token = isset($data['token']) && !empty($data['token']) ? $data['token'] : null;
        if (null == $token)
        {
            $this->response->setStatusCode(400);
            return new JsonModel(array('data' => "You have pass a token with this API call"));
        }

        // Check if user is authenticated.
        Registry::restoreSession($token);
        if (!Registry::isAuthenticated())
        {
            $this->response->setStatusCode(412);
            return new JsonModel(array('data' => "You have to be authenticated to use this api"));
        }

        // Check input parameters.
        if(!$this->validateInputData($this->createParametersRequired, $data))
        {
            $this->response->setStatusCode(400);
            return new JsonModel(array(
                'data' => "You seems to have missed something, please check that you have entered all the parameters required for this call",
                'parameters' => $this->createParametersRequired));
        }

        // Calculate, validate and place order.
        $order = new \ExchangeOrder\DataObject\ExchangeOrder();
        $order->fromArray($data)
              ->calculate();

        if($order->validate())
        {
            return new JsonModel(ExchangeOrders::create($order));
        }

        $this->response->setStatusCode(400);
        return new JsonModel(array(
            'data' => "Validation failed on this order, please check that you have entered all the parameters required for this call",
            'parameters' => $this->createParametersRequired));
    }

    protected function validateInputData(array $expected, array $actual)
    {
        foreach($expected as $value)
        {
            if(!isset($actual[$value]))
            {
                return false;
            }
        }
        return true;
    }
}