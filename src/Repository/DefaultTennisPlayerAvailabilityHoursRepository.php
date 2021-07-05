<?php

namespace App\Repository;

use App\Entity\DefaultTennisPlayerAvailabilityHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DefaultTennisPlayerAvailabilityHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method DefaultTennisPlayerAvailabilityHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method DefaultTennisPlayerAvailabilityHours[]    findAll()
 * @method DefaultTennisPlayerAvailabilityHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefaultTennisPlayerAvailabilityHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DefaultTennisPlayerAvailabilityHours::class);
    }

    public function UniqueHours()
    {
        return $this->createQueryBuilder('t')
            ->select('t.hour')
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return DefaultTennisPlayerAvailabilityHours[] Returns an array of DefaultTennisPlayerAvailabilityHours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DefaultTennisPlayerAvailabilityHours
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
