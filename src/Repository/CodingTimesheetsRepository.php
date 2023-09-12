<?php

namespace App\Repository;

use App\Entity\CodingTimesheets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodingTimesheets>
 *
 * @method CodingTimesheets|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodingTimesheets|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodingTimesheets[]    findAll()
 * @method CodingTimesheets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodingTimesheetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodingTimesheets::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CodingTimesheets $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CodingTimesheets $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return CodingTimesheets[] Returns an array of CodingTimesheets objects
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
    public function findOneBySomeField($value): ?CodingTimesheets
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
