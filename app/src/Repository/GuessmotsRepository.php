<?php

namespace App\Repository;

use App\Entity\Guessmots;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Guessmots>
 *
 * @method Guessmots|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guessmots|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guessmots[]    findAll()
 * @method Guessmots[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuessmotsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guessmots::class);
    }

//    /**
//     * @return Guessmots[] Returns an array of Guessmots objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Guessmots
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
