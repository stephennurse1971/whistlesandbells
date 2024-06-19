<?php

namespace App\Repository\ProjectSpecific;

use App\Entity\ProjectSpecific\MarketData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MarketData|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketData|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketData[]    findAll()
 * @method MarketData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketData::class);
    }

    // /**
    //  * @return MarketData[] Returns an array of MarketData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MarketData
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
