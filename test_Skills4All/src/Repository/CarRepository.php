<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\CarCategory;
use App\Model\SearchData;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function add(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findForPagination(?CarCategory $carCategory = null): Query{
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC');

        
        if ($carCategory){
            $qb->leftJoin('a.carCategories', 'c')
                ->where($qb->expr()->eq('c.id', ':carCategoryId'))
                ->setParameter('carCategoryId', $carCategory->getId());
        }
        return $qb->getQuery();
    }

    public function findBySearch(SearchData $searchData, PaginatorInterface $paginator): PaginationInterface
    {
        if(!empty($searchData->q)) {
            $car = $this->createQueryBuilder('p')
            ->addOrderBy('p.id', 'DESC');
            $car = $car->andWhere('p.name LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }
        $car = $car->getQuery()->getResult();
        $pagination = $paginator->paginate($car, $searchData->page, 9);
        return $pagination;
    }

//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
