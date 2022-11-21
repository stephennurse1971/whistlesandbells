<?php

namespace App\Repository;

use App\Entity\CmsPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CmsPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method CmsPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method CmsPhoto[]    findAll()
 * @method CmsPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CmsPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CmsPhoto::class);
    }

    // /**
    //  * @return CmsPhoto[] Returns an array of CmsPhoto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CmsPhoto
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
