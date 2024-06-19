<?php

namespace App\Repository\ProjectSpecific;

use App\Entity\ProjectSpecific\TaxSupportingDocs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaxSupportingDocs|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxSupportingDocs|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxSupportingDocs[]    findAll()
 * @method TaxSupportingDocs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxSupportingDocsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxSupportingDocs::class);
    }

    // /**
    //  * @return TaxSupportingDocs[] Returns an array of TaxSupportingDocs objects
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
    public function findOneBySomeField($value): ?TaxSupportingDocs
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
