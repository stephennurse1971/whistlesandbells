<?php

namespace App\Repository;

use App\Entity\HouseGuests;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HouseGuests|null find($id, $lockMode = null, $lockVersion = null)
 * @method HouseGuests|null findOneBy(array $criteria, array $orderBy = null)
 * @method HouseGuests[]    findAll()
 * @method HouseGuests[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseGuestsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HouseGuests::class);
    }

    // /**
    //  * @return HouseGuests[] Returns an array of HouseGuests objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HouseGuests
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
