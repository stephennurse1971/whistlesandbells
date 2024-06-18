<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\UkDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UkDays|null find($id, $lockMode = null, $lockVersion = null)
 * @method UkDays|null findOneBy(array $criteria, array $orderBy = null)
 * @method UkDays[]    findAll()
 * @method UkDays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UkDaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UkDays::class);
    }

    // /**
    //  * @return UkDays[] Returns an array of UkDays objects
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
    public function findOneBySomeField($value): ?UkDays
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
