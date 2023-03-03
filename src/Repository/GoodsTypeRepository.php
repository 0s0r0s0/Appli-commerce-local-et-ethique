<?php

namespace App\Repository;

use App\Entity\GoodsType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GoodsType|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoodsType|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoodsType[]    findAll()
 * @method GoodsType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoodsTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoodsType::class);
    }

    // /**
    //  * @return GoodsType[] Returns an array of GoodType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GoodsType
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
