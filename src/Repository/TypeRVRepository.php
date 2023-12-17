<?php

namespace App\Repository;

use App\Entity\TypeRV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeRV>
 *
 * @method TypeRV|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeRV|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeRV[]    findAll()
 * @method TypeRV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeRV::class);
    }

//    /**
//     * @return TypeRV[] Returns an array of TypeRV objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeRV
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
