<?php

namespace App\Repository;

use App\Entity\EatenMeals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EatenMeals>
 *
 * @method EatenMeals|null find($id, $lockMode = null, $lockVersion = null)
 * @method EatenMeals|null findOneBy(array $criteria, array $orderBy = null)
 * @method EatenMeals[]    findAll()
 * @method EatenMeals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EatenMealsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EatenMeals::class);
    }

//    /**
//     * @return EatenMeals[] Returns an array of EatenMeals objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EatenMeals
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
