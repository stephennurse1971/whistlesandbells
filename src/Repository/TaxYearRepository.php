<?php

namespace App\Repository;

use App\Entity\TaxYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaxYear|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxYear|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxYear[]    findAll()
 * @method TaxYear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxYearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxYear::class);
    }

    // /**
    //  * @return TaxYear[] Returns an array of TaxYear objects
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
    public function findOneBySomeField($value): ?TaxYear
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
