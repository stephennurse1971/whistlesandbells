<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\JpmIcHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JpmIcHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method JpmIcHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method JpmIcHistory[]    findAll()
 * @method JpmIcHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JpmIcHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JpmIcHistory::class);
    }

    // /**
    //  * @return JpmIcHistory[] Returns an array of JpmIcHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JpmIcHistory
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
