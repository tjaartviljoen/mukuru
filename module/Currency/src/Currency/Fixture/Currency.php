<?php
namespace Currency\Fixture;

use Fixture\Service\Fixture;

class Currency extends Fixture
{

    /**
     * Build currency fixtures.
     */
    static public function build()
    {
        parent::addStack(
            '\Currency\Entity\Currency',
            array(
                'currency.usd' => array(
                    'name'                    => 'US Dollars',
                    'code'                    => 'USD',
                    'baseExchangeRate'        => 0.0808279,
                    'surchargePercentage'     => 7.5,
                    'totalDiscountPercentage' => 0
                ),
                'currency.GBD' => array(
                    'name'                    => 'British Pound',
                    'code'                    => 'GBD',
                    'baseExchangeRate'        => 0.0527032,
                    'surchargePercentage'     => 5,
                    'totalDiscountPercentage' => 0,
                    'executeAfter'            => 'email'
                ),
                'currency.EUR' => array(
                    'name'                    => 'Euro',
                    'code'                    => 'EUR',
                    'baseExchangeRate'        => 0.0718710,
                    'surchargePercentage'     => 5,
                    'totalDiscountPercentage' => 2,
                ),
                'currency.KES' => array(
                    'name'                    => 'Kenyan Shilling',
                    'code'                    => 'KES',
                    'baseExchangeRate'        => 7.81498,
                    'surchargePercentage'     => 2.5,
                    'totalDiscountPercentage' => 0,
                )
            )
        );
    }
}