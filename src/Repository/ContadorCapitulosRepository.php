<?php

namespace App\Repository;

use App\Entity\ContadorCapitulos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContadorCapitulos>
 *
 * @method ContadorCapitulos|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContadorCapitulos|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContadorCapitulos[]    findAll()
 * @method ContadorCapitulos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContadorCapitulosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContadorCapitulos::class);
    }

//    /**
//     * @return ContadorCapitulos[] Returns an array of ContadorCapitulos objects
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

//    public function findOneBySomeField($value): ?ContadorCapitulos
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
