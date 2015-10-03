<?php
namespace Currency\Entity;

use Doctrine\ORM\Mapping as ORM;
use Utility\Entity\EntityBase;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="currency", uniqueConstraints={@ORM\UniqueConstraint(name="unique_name", columns={"name"})})
 */
class Currency extends EntityBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, name="name", unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=3, name="code")
     */
    protected $code;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=false)
     */
    protected $baseExchangeRate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=true)
     */
    protected $updatedExchangeRate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=false)
     */
    protected $surchargePercentage;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=7, nullable=false)
     */
    protected $totalDiscountPercentage;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $executeAfter;

    /**
     * @ORM\Column(type="datetime", nullable=false);
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true);
     */
    protected $updated;

    //-- Meta data.
    protected $basicFields = array(
        'id',
        'name',
        'code',
        'baseExchangeRate',
        'updatedExchangeRate',
        'surchargePercentage',
        'totalDiscountPercentage',
        'executeAfter'
    );
    protected $dateTimeFields = array(
        'created',
        'updated'
    );

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}