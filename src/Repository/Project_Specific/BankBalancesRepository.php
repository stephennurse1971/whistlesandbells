<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\BankAccounts;
use App\Entity\Project_Specific\BankBalances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BankBalances>
 *
 * @method BankBalances|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankBalances|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankBalances[]    findAll()
 * @method BankBalances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankBalancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankBalances::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BankBalances $entity, bool $flush = true): void
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
    public function remove(BankBalances $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BankBalances[] Returns an array of BankBalances objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BankBalances
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findPricePrevious(BankAccounts $bankAccounts,\DateTimeInterface $date)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.bank = :bank')
            ->setParameter('bank', $bankAccounts)
            ->andWhere('m.date < :date')
            ->setParameter('date',$date)
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
