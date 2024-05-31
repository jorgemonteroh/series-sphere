<?php

namespace App\Repository;

use App\Entity\Temporada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Temporada>
 *
 * @method Temporada|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temporada|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temporada[]    findAll()
 * @method Temporada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemporadaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temporada::class);
    }

   public function buscarTemporadas($serie_id): array
   {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            SELECT * FROM temporada 
            WHERE serie_id = '$serie_id'
            ";

        $resultSet = $conn->executeQuery($sql);

        return $resultSet->fetchAllAssociative();
   }

//    public function findOneBySomeField($value): ?Temporada
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
