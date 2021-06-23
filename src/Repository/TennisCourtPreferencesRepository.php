<?php

namespace App\Repository;

use App\Entity\TennisCourtPreferences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisCourtPreferences|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisCourtPreferences|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisCourtPreferences[]    findAll()
 * @method TennisCourtPreferences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisCourtPreferencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisCourtPreferences::class);
    }

    // /**
    //  * @return TennisCourtPreferences[] Returns an array of TennisCourtPreferences objects
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
    public function findOneBySomeField($value): ?TennisCourtPreferences
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
