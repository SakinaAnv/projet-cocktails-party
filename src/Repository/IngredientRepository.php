<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }



    public function findByQuantiteInferieur($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.inventoryQuantity  <= :value')
            ->setParameter('value', $value)
            ->orderBy('i.inventoryQuantity', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
