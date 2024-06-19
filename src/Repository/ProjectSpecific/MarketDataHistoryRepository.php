<?php

namespace App\Repository\ProjectSpecific;

use App\Entity\ProjectSpecific\MarketData;
use App\Entity\ProjectSpecific\MarketDataHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MarketDataHistory>
 *
 * @method MarketDataHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketDataHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketDataHistory[]    findAll()
 * @method MarketDataHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketDataHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketDataHistory::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(MarketDataHistory $entity, bool $flush = true): void
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
    public function remove(MarketDataHistory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findPricePrevious(MarketData $marketData,\DateTimeInterface $date)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.security = :security')
            ->setParameter('security', $marketData)
            ->andWhere('m.date < :date')
            ->setParameter('date',$date)
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findUniqueSecurity()
    {
        return $this->createQueryBuilder('m')
            ->select('DISTINCT IDENTITY(m.security)')
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?MarketDataHistory
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
