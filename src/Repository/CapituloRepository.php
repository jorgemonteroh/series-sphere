<?php

namespace App\Repository;

use App\Entity\Capitulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Capitulo>
 *
 * @method Capitulo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capitulo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capitulo[]    findAll()
 * @method Capitulo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapituloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capitulo::class);
    }

    public function buscarCapitulos($temporada_id): array
    {
         $conn = $this->getEntityManager()->getConnection();
         $sql = "
             SELECT * FROM capitulo 
             WHERE id_temporada_id = '$temporada_id'
             ";
 
         $resultSet = $conn->executeQuery($sql);
 
         return $resultSet->fetchAllAssociative();
 
    }
}
