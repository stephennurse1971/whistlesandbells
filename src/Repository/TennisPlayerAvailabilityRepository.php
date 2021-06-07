<?php

namespace App\Repository;

use App\Entity\TennisPlayerAvailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisPlayerAvailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisPlayerAvailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisPlayerAvailability[]    findAll()
 * @method TennisPlayerAvailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisPlayerAvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisPlayerAvailability::class);
    }

    public function UniqueDate()
    {
        return $this->createQueryBuilder('t')
            ->select('t.date')
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }

    public function UniqueHour()
    {
        return $this->createQueryBuilder('t')
            ->select('t.hour')
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }

}
