<?php

namespace App\Repository;

use App\Entity\TennisBookings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisBookings|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisBookings|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisBookings[]    findAll()
 * @method TennisBookings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisBookingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisBookings::class);
    }

    // /**
    //  * @return TennisBookings[] Returns an array of TennisBookings objects
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
    public function findOneBySomeField($value): ?TennisBookings
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
