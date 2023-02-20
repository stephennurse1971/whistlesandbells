<?php

namespace App\Repository;

use App\Entity\Flying;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Flying|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flying|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flying[]    findAll()
 * @method Flying[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlyingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flying::class);
    }

    // /**
    //  * @return Flying[] Returns an array of Flying objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Flying
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
