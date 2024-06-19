<?php

namespace App\Repository\ProjectSpecific;

use App\Entity\ProjectSpecific\UkDayCalendar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UkDayCalendar>
 *
 * @method UkDayCalendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method UkDayCalendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method UkDayCalendar[]    findAll()
 * @method UkDayCalendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UkDayCalendarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UkDayCalendar::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UkDayCalendar $entity, bool $flush = true): void
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
    public function remove(UkDayCalendar $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return UkDayCalendar[] Returns an array of UkDayCalendar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UkDayCalendar
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
