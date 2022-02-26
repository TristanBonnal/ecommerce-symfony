<?php

namespace App\Repository;

use App\Entity\OderDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OderDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method OderDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method OderDetails[]    findAll()
 * @method OderDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OderDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OderDetails::class);
    }

    // /**
    //  * @return OderDetails[] Returns an array of OderDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OderDetails
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
