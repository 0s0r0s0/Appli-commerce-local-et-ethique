<?php

namespace App\Repository;

use App\Entity\TradeArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TradeArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method TradeArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method TradeArea[]    findAll()
 * @method TradeArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TradeArea::class);
    }

    // /**
    //  * @return TradeArea[] Returns an array of TradeArea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TradeArea
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
