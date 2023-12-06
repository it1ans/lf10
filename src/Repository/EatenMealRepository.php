<?php

namespace App\Repository;

use App\Entity\EatenMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<EatenMeal>
 *
 * @method EatenMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method EatenMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method EatenMeal[]    findAll()
 * @method EatenMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EatenMealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EatenMeal::class);
    }

    /**
     * @param UserInterface $user
     * @return EatenMeal[]
     */
    public function findByUser(UserInterface $user): array
    {
        return $this->createQueryBuilder('eaten_meal')
            ->andWhere('eaten_meal.user = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param UserInterface $user
     * @return float
     */
    public function findTodayCalories(UserInterface $user): float
    {
        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');

        $qb = $this->createQueryBuilder('eaten_meal');
        return $qb
            ->join('eaten_meal.meal', 'meal')
            ->select('SUM(meal.calories) as caloriesSum')
            ->where(
                $qb->expr()->between('eaten_meal.createdAt', ':today', ':tomorrow')
            )
            ->andWhere('eaten_meal.user = :user')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return EatenMeal[] Returns an array of EatenMeal objects
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

//    public function findOneBySomeField($value): ?EatenMeal
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
