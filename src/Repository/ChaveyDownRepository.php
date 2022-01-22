<?php

namespace App\Repository;

use App\Entity\ChaveyDown;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChaveyDown|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChaveyDown|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChaveyDown[]    findAll()
 * @method ChaveyDown[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChaveyDownRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChaveyDown::class);
    }

    // /**
    //  * @return ChaveyDown[] Returns an array of ChaveyDown objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChaveyDown
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
