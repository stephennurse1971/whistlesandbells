<?php

namespace App\Repository;

use App\Entity\Player2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Player2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player2[]    findAll()
 * @method Player2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Player2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player2::class);
    }

    // /**
    //  * @return Player2[] Returns an array of Player2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Player2
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
