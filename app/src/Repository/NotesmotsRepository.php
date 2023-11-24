<?php

namespace App\Repository;

use App\Entity\Notesmots;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notesmots>
 *
 * @method Notesmots|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notesmots|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notesmots[]    findAll()
 * @method Notesmots[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesmotsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notesmots::class);
    }

//    /**
//     * @return Notesmots[] Returns an array of Notesmots objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notesmots
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
