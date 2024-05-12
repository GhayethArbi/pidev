<?php

namespace App\Repository;

use App\Entity\ActivitePhysique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
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
    public function findActivitiesWithUniqueNames()
    {
        $result = $this->createQueryBuilder('a')
        ->select('a.Nom_Activite', 'a.Type_Activite', 'a.Image_Activite')
        ->groupBy('a.Nom_Activite')
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    $hydratedObjects = [];
    foreach ($result as $row) {
        $hydratedObjects[] = (new ActivitePhysique())
            ->setNomActivite($row['Nom_Activite'])
            ->setTypeActivite($row['Type_Activite'])
            ->setImageActivite($row['Image_Activite']);
        // Set other properties as needed
    }
    //dd($hydratedObjects) ;
    return $hydratedObjects;
        // Extrait uniquement les colonnes Nom_Activite, Type_Activite et Image_Activie
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
