<?php

namespace App\Repository;

use App\Entity\TennisPlayers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisPlayers|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisPlayers|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisPlayers[]    findAll()
 * @method TennisPlayers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisPlayersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisPlayers::class);
    }

    // /**
    //  * @return TennisPlayers[] Returns an array of TennisPlayers objects
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
    public function findOneBySomeField($value): ?TennisPlayers
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
