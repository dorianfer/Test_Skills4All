<?php

namespace App\Repository;

use App\Entity\CarCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Model\SearchData;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<CarCategory>
 *
 * @method CarCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarCategory[]    findAll()
 * @method CarCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarCategory::class);
    }

    public function add(CarCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CarCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByGroup(){
        $category = $this->createQueryBuilder('p')->addOrderBy('p.name', 'DESC');
        $category = $category->groupBy('p.name');

        $category = $category->getQuery()->getResult();
        return $category;
    }

    public function findAllCategory(String $carCategoryname){
        $category = $this->createQueryBuilder('p')->addSelect('c')->leftJoin('p.car', 'c', "WITH", "p.car = c.id")->andWhere('p.name = :q')
        ->setParameter('q', "{$carCategoryname}");
        

        $category = $category->getQuery()->getResult();
        return $category;
    }

    public function findBySearchCategory(SearchData $searchData, PaginatorInterface $paginator, String $carCategoryname): PaginationInterface
    {
        $car = $this->createQueryBuilder('p')->addSelect('c')
            ->addOrderBy('p.id', 'DESC');
        if ($carCategoryname){
            $car = $car->leftJoin('p.car', 'c', "WITH", "p.car = c.id")->andWhere('p.name = :r');
            
        }
        if(!empty($searchData->q)) {
            $car = $car->andWhere('c.name LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }
        $car = $car->setParameter('r', "{$carCategoryname}");

        $car = $car->getQuery()->getResult();
        $pagination = $paginator->paginate($car, $searchData->page, 9);
        return $pagination;
    }

//    /**
//     * @return CarCategory[] Returns an array of CarCategory objects
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

//    public function findOneBySomeField($value): ?CarCategory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
