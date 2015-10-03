<?php
namespace Order\Service;

interface OrderServiceInterface
{
    public function getList();

    public function get($id);

    public function create($order);
}