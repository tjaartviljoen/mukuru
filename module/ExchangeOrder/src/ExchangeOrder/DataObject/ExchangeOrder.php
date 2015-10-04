<?php
namespace ExchangeOrder\DataObject;

use Currency\Repository\Currencies;
use Utility\Registry;

class ExchangeOrder
{

    protected $fromArrayMap = array('currencyId', 'userId', 'foreignCurrencyAmount', 'localCurrencyAmount');
    /**
     * @var int
     */
    protected $currencyId, $userId;

    /**
     * @var float
     */
    protected $exchangeRate, $surchargePercentage, $totalDiscountPercentage, $foreignCurrencyAmount, $localCurrencyAmount,
        $surchargeAmount, $totalBilledAmount;

    /**
     * @var string
     */
    protected $executeAfter, $currencyCode;


    function __construct()
    {

    }

    /**
     * Set the currency id.
     *
     * @param int $value
     * @return \ExchangeOrder\DataObject\ExchangeOrder
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
     * @return \ExchangeOrder\DataObject\ExchangeOrder
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
     * @return \ExchangeOrder\DataObject\ExchangeOrder
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
     * @return \ExchangeOrder\DataObject\ExchangeOrder
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
     * @return \ExchangeOrder\DataObject\ExchangeOrder
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
     * @return \ExchangeOrder\DataObject\ExchangeOrder
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
     * @return \ExchangeOrder\DataObject\ExchangeOrder
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
     * @return \ExchangeOrder\DataObject\ExchangeOrder
     */
    public function setSurchargeAmount($value)
    {
        $this->surchargeAmount = $value;
        return $this;
    }

    /**
     * Populate and return and ExchangeOrder entity.
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @param \ExchangeOrder\Entity\ExchangeOrder $entity
     * @return \ExchangeOrder\Entity\ExchangeOrder
     * @throws \Doctrine\ORM\ORMException
     */
    public function populateEntity(\Doctrine\ORM\EntityManager $em, \ExchangeOrder\Entity\ExchangeOrder $entity)
    {
        $entity->currency = $em->getReference('Currency\Entity\Currency', $this->currencyId);
        $entity->user = $em->getReference('User\Entity\User', $this->userId);
        $entity->exchangeRate = $this->exchangeRate;
        $entity->surchargePercentage = $this->surchargePercentage;
        $entity->totalDiscountPercentage = $this->totalDiscountPercentage;
        $entity->foreignCurrencyAmount = $this->foreignCurrencyAmount;
        $entity->localCurrencyAmount = $this->localCurrencyAmount;
        $entity->surchargeAmount = $this->surchargeAmount;

        if ($this->totalDiscountPercentage > 0.0)
        {
            $discountAmount = bcmul($this->totalBilledAmount, bcdiv($this->totalDiscountPercentage, 100, 7), 7);
            $this->totalBilledAmount = bcsub($this->totalBilledAmount, $discountAmount, 7);
        }

        $entity->totalBilledAmount = $this->totalBilledAmount;
        return $entity;
    }

    /**
     * Set data object properties from array
     * @param $data
     * @return \ExchangeOrder\DataObject\ExchangeOrder
     */
    public function fromArray($data)
    {
        foreach ($this->fromArrayMap as $key)
        {
            if (isset($data[$key]))
            {
                $this->$key = $data[$key];
            }
        }
        return $this;
    }

    /**
     * Calculate required surcharge, discount,
     * @return $this
     */
    public function calculate()
    {
        $currency = Currencies::get($this->currencyId);

        if (null != $currency)
        {
            $this->currencyCode = $currency['code'];
            $this->exchangeRate = isset($currency['updatedExchangeRate']) && $currency['updatedExchangeRate'] > 0.0
                ? $currency['updatedExchangeRate']
                : $currency['baseExchangeRate'];

            $this->surchargePercentage = $currency['surchargePercentage'];
            $this->totalDiscountPercentage = $currency['totalDiscountPercentage'];
            $this->executeAfter = $currency['executeAfter'];

            $surchargeRate = bcdiv($this->surchargePercentage, 100.0, 7);

            if (0.0 < $this->foreignCurrencyAmount)
            {
                error_log('Using $this->foreignCurrencyAmount');
                $this->localCurrencyAmount = bcdiv($this->foreignCurrencyAmount, $surchargeRate, 7);
                $this->surchargeAmount = bcmul($this->localCurrencyAmount, $surchargeRate, 7);
                $this->totalBilledAmount = bcadd($this->localCurrencyAmount, $this->surchargeAmount, 7);
            }
            else if (0.0 < $this->localCurrencyAmount)
            {
                error_log('Using $this->localCurrencyAmount');
                $this->surchargeAmount = bcsub($this->localCurrencyAmount, bcdiv($this->localCurrencyAmount, $surchargeRate + 1, 7), 7);
                $this->foreignCurrencyAmount = bcmul(bcsub($this->localCurrencyAmount, $this->surchargeAmount, 7), $this->exchangeRate, 7);
                $this->totalBilledAmount = $this->localCurrencyAmount;
            }
        }
        return $this;
    }


    /**
     * Validate whether this data object can be used to populate an ExchangeOrder entity.
     *
     * @return bool
     */
    public function validate()
    {
        // Check for currency and user
        if (!isset($this->currencyId) || !isset($this->userId))
        {
            return false;
        }

        // Check for local and foreign currency
        if (0 == $this->localCurrencyAmount || 0 == $this->foreignCurrencyAmount)
        {
            return false;
        }

        // Check calculated values
        if (!isset($this->exchangeRate) || !isset($this->surchargePercentage) || !isset($this->surchargeAmount) || !isset($this->totalDiscountPercentage) || !isset($this->totalBilledAmount))
        {
            return false;
        }

        return true;
    }

    /**
     * Execute any need action after persist.
     */
    public function executeAfterPersist()
    {
        if ('email' == $this->executeAfter)
        {
            // Send email to dude
        }
    }

    /**
     * Return an array of currencyCode, foreignCurrencyAmount, totalBilledAmount & totalDiscountPercentage for summary display
     *
     * @return array
     */
    public function getSummary()
    {
        return array(
            'currencyCode'            => $this->currencyCode,
            'foreignCurrencyAmount'   => $this->foreignCurrencyAmount,
            'totalBilledAmount'       => $this->totalBilledAmount,
            'totalDiscountPercentage' => $this->totalDiscountPercentage
        );
    }

}