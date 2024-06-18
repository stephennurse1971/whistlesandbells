<?php

namespace App\Repository\Project_Specific;

use App\Entity\Introductio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Introductio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Introductio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Introductio[]    findAll()
 * @method Introductio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntroductioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Introductio::class);
    }

    // /**
    //  * @return Introductio[] Returns an array of Introductio objects
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
    public function findOneBySomeField($value): ?Introductio
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
