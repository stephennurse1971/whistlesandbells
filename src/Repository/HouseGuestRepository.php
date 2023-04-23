<?php

namespace App\Repository;

use App\Entity\HouseGuest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HouseGuest|null find($id, $lockMode = null, $lockVersion = null)
 * @method HouseGuest|null findOneBy(array $criteria, array $orderBy = null)
 * @method HouseGuest[]    findAll()
 * @method HouseGuest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseGuestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HouseGuest::class);
    }

    // /**
    //  * @return HouseGuest[] Returns an array of HouseGuest objects
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
    public function findOneBySomeField($value): ?HouseGuest
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
