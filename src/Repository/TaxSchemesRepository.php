<?php

namespace App\Repository;

use App\Entity\TaxSchemes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaxSchemes|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxSchemes|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxSchemes[]    findAll()
 * @method TaxSchemes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxSchemesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxSchemes::class);
    }

    // /**
    //  * @return TaxSchemes[] Returns an array of TaxSchemes objects
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
    public function findOneBySomeField($value): ?TaxSchemes
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
