<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }
    
    public function getPaginatedLivres($page){
        $qb = $this->createQueryBuilder("l")
            ->orderBy("l.titre")
            ->setFirstResult(($page-1)*5)
            ->setMaxResults(5)
        ;
        return $qb->getQuery()->getResult();
    }

    public function countLivres()
    {
        return $this->createQueryBuilder('l')
                    ->select("COUNT(l.id)")
                    ->getQuery()
                    ->getSingleScalarResult();
    }



    public function search($titre = null):array
    {
        return $this->createQueryBuilder('l')
                             ->where('l.titre LIKE :titre')
                             ->setParameter('titre','%'.$titre.'%')
                             ->getQuery()->getResult();
    }






    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
