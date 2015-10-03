<?php
namespace Currency\Service;

interface CurrencyServiceInterface
{
    public function getList();

    public function get($id);
}