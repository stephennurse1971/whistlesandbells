<?php

namespace App\Repository\ProjectSpecific;

use App\Entity\ProjectSpecific\FxRatesHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FxRatesHistory>
 *
 * @method FxRatesHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FxRatesHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FxRatesHistory[]    findAll()
 * @method FxRatesHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FxRatesHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FxRatesHistory::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FxRatesHistory $entity, bool $flush = true): void
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
    public function remove(FxRatesHistory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FxRatesHistory[] Returns an array of FxRatesHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FxRatesHistory
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findPreviousRate(\DateTimeInterface $date)
    {
        return $this->createQueryBuilder('m')

            ->andWhere('m.date < :date')
            ->setParameter('date',$date)
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
