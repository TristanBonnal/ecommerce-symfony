<?php

namespace App\Repository;

use App\Entity\Product;
use App\Model\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**Requête custom pour la barre de recherche :
     * Récupérations des produits filtrés par mots-clés et/ou catégories
     * 
     * @return Product[] Returns an array of Product objects
     */
    public function findWithSearch(Search $search): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c')
        ;
        if (!empty($search->getCategories())) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->getCategories())
            ;    
        }

        if (!empty($search->getString())) {
            $query = $query
                ->andWhere('p.name LIKE :string')
                ->setParameter('string', "%{$search->getString()}%")
            ;    
        }

        return $query->getQuery()->getResult();
        
    }

}
