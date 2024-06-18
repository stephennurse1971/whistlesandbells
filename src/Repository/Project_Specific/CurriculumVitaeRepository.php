<?php

namespace App\Repository\Project_Specific;

use App\Entity\Project_Specific\CurriculumVitae;
use App\Entity\Project_Specific\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CurriculumVitae|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurriculumVitae|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurriculumVitae[]    findAll()
 * @method CurriculumVitae[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurriculumVitaeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurriculumVitae::class);
    }


    public function findByCandidate(User $user)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.candidate = :val')
            ->setParameter('val', $user)
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?CurriculumVitae
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function distinctCandidate(){
        return $this->createQueryBuilder('c')
            ->select( 'IDENTITY(c.candidate)' )
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }
}
