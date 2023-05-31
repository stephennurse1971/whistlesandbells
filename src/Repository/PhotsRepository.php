<?php

namespace App\Repository;

use App\Entity\Phots;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Phots|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phots|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phots[]    findAll()
 * @method Phots[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phots::class);
    }

    // /**
    //  * @return Phots[] Returns an array of Phots objects
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
    public function findOneBySomeField($value): ?Phots
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
