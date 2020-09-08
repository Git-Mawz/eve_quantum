<?php

namespace App\Repository;

use App\Entity\Suggest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Suggest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suggest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suggest[]    findAll()
 * @method Suggest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuggestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suggest::class);
    }

    // /**
    //  * @return Suggest[] Returns an array of Suggest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Suggest
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
