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

        if(count($result) > 0)
        {
            return array_pop($result);
        }
        return array();
    }

}