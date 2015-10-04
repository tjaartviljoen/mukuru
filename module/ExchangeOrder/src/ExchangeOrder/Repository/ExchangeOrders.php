<?php
namespace ExchangeOrder\Repository;

use Utility\Registry;

class ExchangeOrders
{
    /**
     * Get all exchange order records ordered by date DESC formatted as an array
     *
     * @param $id
     * @return array
     */
    public static function getList()
    {
        $service = Registry::getServiceManager()->get('ExchangeOrder.Service.ExchangeOrder');
        return $service->getList();
    }

    /**
     * Get an exchange order record formatted as an array
     *
     * @param $id
     * @return array
     */
    public static function get($id)
    {
        $service = Registry::getServiceManager()->get('ExchangeOrder.Service.ExchangeOrder');
        return $service->get($id);
    }

    public static function create($order)
    {
        $service = Registry::getServiceManager()->get('ExchangeOrder.Service.ExchangeOrder');
        return $service->create($order)->toArray();
    }
}