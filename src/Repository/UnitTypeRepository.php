<?php

namespace App\Repository;

use App\Entity\UnitType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UnitType|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnitType|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnitType[]    findAll()
 * @method UnitType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnitType::class);
    }

    // /**
    //  * @return UnitType[] Returns an array of UnitType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnitType
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
