<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\WineList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WineList|null find($id, $lockMode = null, $lockVersion = null)
 * @method WineList|null findOneBy(array $criteria, array $orderBy = null)
 * @method WineList[]    findAll()
 * @method WineList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WineListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WineList::class);
    }

    // /**
    //  * @return WineList[] Returns an array of WineList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WineList
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
