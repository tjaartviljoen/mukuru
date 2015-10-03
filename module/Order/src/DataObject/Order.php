<?php
namespace Order\DataObject;

class Order
{
    /**
     * @var int
     */
    protected $currencyId, $userId;

    /**
     * @var float
     */
    protected $exchangeRate, $surchargePercentage, $totalDiscountPercentage, $foreignCurrencyAmount, $localCurrencyAmount,
              $surchargeAmount;

    function __construct()
    {

    }

    /**
     * Set the currency id.
     *
     * @param int $value
     * @return \Order\DataObject\Order
     */
    public function setCurrencyId($value)
    {
        $this->currencyId = $value;
        return $this;
    }

    /**
     * Set the user id.
     *
     * @param int $value
     * @return \Order\DataObject\Order
     */
    public function setUserId($value)
    {
        $this->userId = $value;
        return $this;
    }

    /**
     * Set the exchange rate.
     *
     * @param float $value
     * @return \Order\DataObject\Order
     */
    public function setExchangeRate($value)
    {
        $this->exchangeRate = $value;
        return $this;
    }

    /**
     * Set the surcharge percentage.
     *
     * @param float $value
     * @return \Order\DataObject\Order
     */
    public function setSurchargePercentage($value)
    {
        $this->surchargePercentage = $value;
        return $this;
    }

    /**
     * Set the total discount percentage.
     *
     * @param float $value
     * @return \Order\DataObject\Order
     */
    public function setTotalDiscountPercentage($value)
    {
        $this->totalDiscountPercentage = $value;
        return $this;
    }

    /**
     * Set the foreign currency amount.
     *
     * @param float $value
     * @return \Order\DataObject\Order
     */
    public function setForeignCurrencyAmount($value)
    {
        $this->foreignCurrencyAmount = $value;
        return $this;
    }

    /**
     * Set the local currency amount.
     *
     * @param float $value
     * @return \Order\DataObject\Order
     */
    public function setLocalCurrencyAmount($value)
    {
        $this->localCurrencyAmount = $value;
        return $this;
    }

    /**
     * Set the surcharge amount.
     *
     * @param float $value
     * @return \Order\DataObject\Order
     */
    public function setSurchargeAmount($value)
    {
        $this->surchargeAmount = $value;
        return $this;
    }

    /**
     * Validate whether this data object can be used to populate an Order entity.
     *
     * @return bool
     */
    public function validate()
    {
        return false;
    }

    /**
     * Populate and return and Order entity.
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Order\Entity\Order $entity
     * @return \Order\Entity\Order
     * @throws \Doctrine\ORM\ORMException
     */
    public function populateEntity(\Doctrine\ORM\EntityManager $em, \Order\Entity\Order $entity)
    {
        $entity->currency = $em->getReference('Currency\Entity\Currency', $this->currencyId);
        $entity->user = $em->getReference('User\Entity\Entity', $this->userId);
        $entity->exchangeRate = $this->exchangeRate;
        $entity->surchargePercentage = $this->surchargePercentage;
        $entity->totalDiscountPercentage = $this->totalDiscountPercentage;
        $entity->foreignCurrencyAmount = $this->foreignCurrencyAmount;
        $entity->localCurrencyAmount = $this->localCurrencyAmount;
        $entity->surchargeAmount = $this->surchargeAmount;

        return $entity;
    }

}