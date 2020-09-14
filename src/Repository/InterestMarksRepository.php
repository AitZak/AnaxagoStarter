<?php

namespace App\Repository;

use App\Entity\InterestMarks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InterestMarks|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterestMarks|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterestMarks[]    findAll()
 * @method InterestMarks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterestMarksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterestMarks::class);
    }

    // /**
    //  * @return InterestMarks[] Returns an array of InterestMarks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InterestMarks
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
