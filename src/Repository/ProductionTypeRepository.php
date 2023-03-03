<?php

namespace App\Repository;

use App\Entity\ProductionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionType[]    findAll()
 * @method ProductionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductionType::class);
    }

    // /**
    //  * @return ProductionType[] Returns an array of ProductionType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductionType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
