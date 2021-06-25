<?php

namespace App\Repository;

use App\Entity\TennisVenues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisVenues|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisVenues|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisVenues[]    findAll()
 * @method TennisVenues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisVenuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisVenues::class);
    }

    // /**
    //  * @return TennisVenues[] Returns an array of TennisVenues objects
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


    public function sortVenuesByRegion()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.londonRegion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
