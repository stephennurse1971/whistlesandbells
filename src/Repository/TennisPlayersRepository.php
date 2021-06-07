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

    public function UniquePlayer()
    {
        return $this->createQueryBuilder('t')
            ->select('t.name')
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }

}
