<?php
namespace Currency\Repository;

use Utility\Registry;

class Currencies
{
    /**
     * Currency\Service\Currency->getList() proxy method.
     * @return array
     */
    public static function getList()
    {
        $service = Registry::getServiceManager()->get('Currency.Service.Currency');
        return $service->getList();
    }

    public static function get($id)
    {
        $service = Registry::getServiceManager()->get('Currency.Service.Currency');
        return $service->get($id);
    }

    public static function getJsonRates()
    {
        $service = Registry::getServiceManager()->get('Currency.Service.Currency');
        return $service->getJsonRates();
    }
}