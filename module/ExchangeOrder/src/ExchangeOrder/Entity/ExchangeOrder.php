<?php
namespace ExchangeOrder\Entity;

use Doctrine\ORM\Mapping as ORM;
use Utility\Entity\EntityBase;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="exchange_order")
 */
class ExchangeOrder extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Currency\Entity\Currency", fetch="EAGER")
     * @ORM\JoinColumn(name="currency_id", nullable=false)
     */
    protected $currency;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(name="currency_id", nullable=false)
     */
    protected $user;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, name="exchange_rate", nullable=false)
     */
    protected $exchangeRate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, name="surcharge_percentage", nullable=false)
     */
    protected $surchargePercentage;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, name="total_discount_percentage", nullable=false)
     */
    protected $totalDiscountPercentage;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, name="foreign_currency_amount", nullable=false)
     */
    protected $foreignCurrencyAmount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, name="local_currency_amount", nullable=false)
     */
    protected $localCurrencyAmount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, name="total_billed_amount", nullable=false)
     */
    protected $totalBilledAmount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, name="surcharge_amount", nullable=false)
     */
    protected $surchargeAmount;

    /**
     * @ORM\Column(type="datetime", nullable=false);
     */
    protected $created;


    //-- Meta data.
    protected $basicFields = array(
        'id',
        'exchangeRate',
        'surchargePercentage',
        'totalDiscountPercentage',
        'foreignCurrencyAmount',
        'surchargePercentage',
        'localCurrencyAmount',
        'surchargeAmount'
    );
    protected $dateTimeFields = array(
        'created'
    );

    protected $referenceFields = array(
        'currency' => 'Currency\Entity\Currency',
        'user'     => 'User\Entity\User'
    );

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }
}