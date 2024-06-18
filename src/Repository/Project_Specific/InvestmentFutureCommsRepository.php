<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\InvestmentFutureComms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InvestmentFutureComms|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvestmentFutureComms|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvestmentFutureComms[]    findAll()
 * @method InvestmentFutureComms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvestmentFutureCommsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvestmentFutureComms::class);
    }

    // /**
    //  * @return InvestmentFutureComms[] Returns an array of InvestmentFutureComms objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InvestmentFutureComms
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
