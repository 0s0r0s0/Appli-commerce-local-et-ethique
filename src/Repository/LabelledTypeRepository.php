<?php

namespace App\Repository;

use App\Entity\LabelledType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LabelledType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LabelledType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LabelledType[]    findAll()
 * @method LabelledType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelledTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LabelledType::class);
    }

    // /**
    //  * @return LabelledType[] Returns an array of LabelledType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LabelledType
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
