<?php

namespace App\Repository;

use App\Entity\TaxInputs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaxInputs|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxInputs|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxInputs[]    findAll()
 * @method TaxInputs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxInputsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxInputs::class);
    }

    // /**
    //  * @return TaxInputs[] Returns an array of TaxInputs objects
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
    public function findOneBySomeField($value): ?TaxInputs
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
