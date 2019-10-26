<?php

namespace App\Repository;

use App\Entity\JobEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobEntity[]    findAll()
 * @method JobEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobEntity::class);
    }

    // /**
    //  * @return JobServices[] Returns an array of JobServices objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobServices
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
