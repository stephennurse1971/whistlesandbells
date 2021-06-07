<?php

namespace App\Repository;

use App\Entity\TennisCourtAvailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisCourtAvailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisCourtAvailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisCourtAvailability[]    findAll()
 * @method TennisCourtAvailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisCourtAvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisCourtAvailability::class);
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
    public function findOneBySomeField($value): ?TennisCourtAvailability
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
