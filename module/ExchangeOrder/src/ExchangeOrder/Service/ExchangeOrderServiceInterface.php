<?php
namespace ExchangeOrder\Service;

interface ExchangeOrderServiceInterface
{
    public function getList();

    public function get($id);

    public function create(\ExchangeOrder\DataObject\ExchangeOrder $order);
}