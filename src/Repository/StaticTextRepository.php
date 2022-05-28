<?php

namespace App\Repository;

use App\Entity\StaticText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StaticText|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaticText|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaticText[]    findAll()
 * @method StaticText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaticTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StaticText::class);
    }

    // /**
    //  * @return StaticText[] Returns an array of StaticText objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StaticText
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
