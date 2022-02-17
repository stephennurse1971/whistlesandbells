<?php

namespace App\Repository;

use App\Entity\FxRates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FxRates|null find($id, $lockMode = null, $lockVersion = null)
 * @method FxRates|null findOneBy(array $criteria, array $orderBy = null)
 * @method FxRates[]    findAll()
 * @method FxRates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FxRatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FxRates::class);
    }

    // /**
    //  * @return FxRates[] Returns an array of FxRates objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FxRates
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
