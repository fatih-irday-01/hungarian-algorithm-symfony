<?php

namespace App\Repository;

use App\Entity\DevelopersJobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DevelopersJobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevelopersJobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevelopersJobs[]    findAll()
 * @method DevelopersJobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevelopersJobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevelopersJobs::class);
    }

    // /**
    //  * @return DevelopersJobs[] Returns an array of DevelopersJobs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DevelopersJobs
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
