<?php

namespace App\Repository\ProjectSpecific;

use App\Entity\ProjectSpecific\TouristAttraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TouristAttraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method TouristAttraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method TouristAttraction[]    findAll()
 * @method TouristAttraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TouristAttractionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TouristAttraction::class);
    }

    // /**
    //  * @return TouristAttraction[] Returns an array of TouristAttraction objects
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
    public function findOneBySomeField($value): ?TouristAttraction
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
