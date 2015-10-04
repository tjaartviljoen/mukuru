<?php
namespace ExchangeOrder\Service;


use Utility\Registry;

class ExchangeOrder implements ExchangeOrderServiceInterface
{

    public function getList()
    {
        $em = Registry::getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select('e')
           ->from('ExchangeOrder\Entity\ExchangeOrder', 'e')
           ->orderBy('e.created', 'DESC');

        return $qb->getQuery()->getArrayResult();
    }

    public function get($id)
    {
        $em = Registry::getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select('e')
           ->from('ExchangeOrder\Entity\ExchangeOrder', 'e')
           ->where('e.id = :id')
           ->setParameter('id', $id);

        $result = $qb->getQuery()->getArrayResult();

        if(count($result) > 0)
        {
            return array_pop($result);
        }
        return array();
    }

    /**
     * Create a new exchange order.
     *
     * @param \ExchangeOrder\DataObject\ExchangeOrder $order
     * @return ExchangeOrderResponse
     */
    public function create(\ExchangeOrder\DataObject\ExchangeOrder $order)
    {
        $em = Registry::getEntityManager();
        $entity = new \ExchangeOrder\Entity\ExchangeOrder();

        try
        {
            $em->beginTransaction();
            $order->populateEntity($em, $entity);
            $em->persist($entity);
            $em->flush($entity);

            $order->executeAfterPersist();
            $em->commit();

            return new ExchangeOrderResponse('Success', 'Order placed successfully', $order->getSummary());
        }
        catch(\Exception $e)
        {
            return new ExchangeOrderResponse('Failure', $e->getMessage());
            $em->rollback();
        }

    }
}

class ExchangeOrderResponse
{
    public $status;
    public $message;
    public $orderData;

    function __construct($status, $message, $orderData = array())
    {
        $this->status = $status;
        $this->message = $message;
        $this->orderData = $orderData;
    }

    public function toArray()
    {
        return array(
            'status' => $this->status,
            'message' => $this->message,
            'orderData' => $this->orderData
        );
    }
}