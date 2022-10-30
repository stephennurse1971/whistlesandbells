<?php

namespace App\Repository;

use App\Entity\RecruiterEmails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecruiterEmails|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecruiterEmails|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecruiterEmails[]    findAll()
 * @method RecruiterEmails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecruiterEmailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecruiterEmails::class);
    }

    // /**
    //  * @return RecruiterEmails[] Returns an array of RecruiterEmails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecruiterEmails
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
