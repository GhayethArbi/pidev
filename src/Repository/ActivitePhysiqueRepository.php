<?php

namespace App\Repository;

use App\Entity\ActivitePhysique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActivitePhysique>
 *
 * @method ActivitePhysique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivitePhysique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivitePhysique[]    findAll()
 * @method ActivitePhysique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivitePhysiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivitePhysique::class);
    }

//    /**
//     * @return ActivitePhysique[] Returns an array of ActivitePhysique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ActivitePhysique
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
