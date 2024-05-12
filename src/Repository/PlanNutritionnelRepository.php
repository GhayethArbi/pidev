<?php

namespace App\Repository;

use App\Entity\PlanNutritionnel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlanNutritionnel>
 *
 * @method PlanNutritionnel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanNutritionnel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanNutritionnel[]    findAll()
 * @method PlanNutritionnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanNutritionnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanNutritionnel::class);
    }

//    /**
//     * @return PlanNutritionnel[] Returns an array of PlanNutritionnel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlanNutritionnel
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
