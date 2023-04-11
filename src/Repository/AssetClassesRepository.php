<?php

namespace App\Repository;

use App\Entity\AssetClasses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AssetClasses|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetClasses|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetClasses[]    findAll()
 * @method AssetClasses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetClassesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssetClasses::class);
    }

    // /**
    //  * @return AssetClasses[] Returns an array of AssetClasses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AssetClasses
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
