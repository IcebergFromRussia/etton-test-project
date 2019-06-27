<?php

namespace App\Repository;

use App\Entity\ProdectType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProdectType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProdectType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProdectType[]    findAll()
 * @method ProdectType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdectTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProdectType::class);
    }

    // /**
    //  * @return ProdectType[] Returns an array of ProdectType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProdectType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
