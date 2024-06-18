<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\ProspectEmployer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProspectEmployer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProspectEmployer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProspectEmployer[]    findAll()
 * @method ProspectEmployer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectEmployerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProspectEmployer::class);
    }

    // /**
    //  * @return ProspectEmployer[] Returns an array of ProspectEmployer objects
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
    public function findOneBySomeField($value): ?ProspectEmployer
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
