<?php

namespace App\Repository;

use App\Entity\Testament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Testament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testament[]    findAll()
 * @method Testament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testament::class);
    }

    // /**
    //  * @return Testament[] Returns an array of Testament objects
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
    public function findOneBySomeField($value): ?Testament
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
