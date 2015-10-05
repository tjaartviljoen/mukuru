<?php
namespace Currency\Service;

use Utility\Registry;

class Currency implements CurrencyServiceInterface
{
    /**
     * Get a list of currencies ordered by name
     * @return array
     */
    public function getList()
    {
        $em = Registry::getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select('c')
           ->from('Currency\Entity\Currency', 'c')
           ->orderBy('c.name');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Get a currency record as an array
     * @param $id
     * @return array
     */
    public function get($id)
    {
        $em = Registry::getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select('c')
           ->from('Currency\Entity\Currency', 'c')
           ->where('c.id = :id')
           ->setParameter('id', $id);

        $result = $qb->getQuery()->getArrayResult();

        if (count($result) > 0)
        {
            return array_pop($result);
        }
        return array();
    }

    public function getJsonRates()
    {
        // Get exchange rates fron API
        $url = 'http://www.apilayer.net/api/live?access_key=46ab2a1a4def412650d3794f3b661731&format=1&currencies=GBP,EUR,KES,ZAR';
        try
        {
            $data = json_decode(file_get_contents($url), true);

            // Calculate rates VS ZAR
            $USDExchangeRate = bcdiv(1.0, $data['quotes']['USDZAR'], 7);
            $GBPExchangeRate = bcmul($USDExchangeRate, $data['quotes']['USDGBP'], 7);
            $EURExchangeRate = bcmul($USDExchangeRate, $data['quotes']['USDEUR'], 7);
            $KESExchangeRate = bcmul($USDExchangeRate, $data['quotes']['USDKES'], 7);

            $this->updateCurrencyByCode('USD', $USDExchangeRate)
                 ->updateCurrencyByCode('GBD', $GBPExchangeRate)
                 ->updateCurrencyByCode('EUR', $EURExchangeRate)
                 ->updateCurrencyByCode('KES', $KESExchangeRate);

            return PHP_EOL . 'Exchange rate updated successfully.' . PHP_EOL . PHP_EOL;
        }
        catch (\Exception $e)
        {
            return 'EXCEPTION: ' . $e->getMessage();
        }
    }

    /**
     * Update exchange rate by currency CODE
     *
     * @param string $currencyCode
     * @param float $rate
     * @return \Currency\Service\Currency
     */
    protected function updateCurrencyByCode($currencyCode, $rate)
    {
        // Get record to update
        $em = Registry::getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('c')
           ->from('Currency\Entity\Currency', 'c')
            ->where('c.code = :code')
            ->setParameter('code', $currencyCode);

        $result = $qb->getQuery()->getResult();

        if(count($result) > 0)
        {
            $entity = array_pop($result);

            // Set rate and commit changes
            $entity->updateRate($rate);
            $em->flush($entity);
        }

        return $this;
    }

}