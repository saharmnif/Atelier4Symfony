<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getAuthorsOrderByName(){
        // 1. Accéder à l'EntityManager
        $em = $this -> getEntityManager();
        // 2. Créer une Requête DQL avec createQuery
        $query= $em->createQuery('SELECT a from App\Entity\Author Order by a.name ASC');
        // 4. Exécuter la Requête
        return $query -> getResult();
    }
    // public function getAuthorByEmail($e){
    // $em = $this -> getEntityManager();
    //     $query= $em->createQuery('SELECT a from App\Entity\Author where a.email = :eml');
    //     // 3. Définir des Paramètres
    //     $query -> setParameter('eml',$e);
    //     // 4. Exécuter la Requête
    //     return $query -> getResult();

    // }
    //En QueryBuilder : 
    public function getAuthorsOrderByNameQB(){
        $req = $this -> createQueryBuilder('a')
             ->orderBy('a.name','ASC')
             ->getQuery()
            ->getResult();
    }
    //1
    public function getAuthorByEmail()
{
    $qb = $this->createQueryBuilder('a')
               ->orderBy('a.email', 'ASC');
    return $qb->getQuery()->getResult();
}



}
