<?php

namespace App\Repository;

use App\Entity\SolarSystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolarSystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolarSystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolarSystem[]    findAll()
 * @method SolarSystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolarSystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolarSystem::class);
    }

    // /**
    //  * @return SolarSystem[] Returns an array of SolarSystem objects
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
    public function findOneBySomeField($value): ?SolarSystem
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
