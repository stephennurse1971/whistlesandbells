<?php

namespace App\Repository;

use App\Entity\TennisAvailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisAvailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisAvailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisAvailability[]    findAll()
 * @method TennisAvailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisAvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisAvailability::class);
    }



    public function UniqueDate()
    {
        return $this->createQueryBuilder('t')
            ->select('t.date')
            ->distinct()
            ->getQuery()
            ->getResult()
        ;
    }

    public function UniqueHours()
    {
        return $this->createQueryBuilder('t')
            ->select('t.hour')
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?TennisAvailability
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
