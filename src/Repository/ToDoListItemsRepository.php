<?php

namespace App\Repository;

use App\Entity\ToDoListItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ToDoListItems>
 *
 * @method ToDoListItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToDoListItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToDoListItems[]    findAll()
 * @method ToDoListItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToDoListItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToDoListItems::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ToDoListItems $entity, bool $flush = true): void
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
    public function remove(ToDoListItems $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ToDoListItems[] Returns an array of ToDoListItems objects
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
    public function findOneBySomeField($value): ?ToDoListItems
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
