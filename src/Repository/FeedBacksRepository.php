<?php

namespace App\Repository;

use App\Entity\FeedBacks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FeedBacks>
 *
 * @method FeedBacks|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeedBacks|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedBacks[]    findAll()
 * @method FeedBacks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedBacksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedBacks::class);
    }

//    /**
//     * @return FeedBacks[] Returns an array of FeedBacks objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FeedBacks
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
