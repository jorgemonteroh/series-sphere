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

    public function buscarSerieSeguimiento($serie_id): array
   {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            SELECT * FROM contador_capitulos 
            WHERE serie_id = '$serie_id'
            ";

        $resultSet = $conn->executeQuery($sql);

        return $resultSet->fetchAllAssociative();
   }
}
