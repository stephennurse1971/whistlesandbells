<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\GarminFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GarminFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method GarminFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method GarminFiles[]    findAll()
 * @method GarminFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GarminFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarminFiles::class);
    }

    // /**
    //  * @return GarminFiles[] Returns an array of GarminFiles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GarminFiles
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
