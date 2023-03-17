<?php

namespace App\Repository;

use App\Entity\Meubles; // import the Meubles entity
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository; // import the ServiceEntityRepository class
use Doctrine\Persistence\ManagerRegistry; // import the ManagerRegistry class

/**
 * This class extends the ServiceEntityRepository class and is a custom repository for the Meubles entity.
 *
 * @extends ServiceEntityRepository<Meubles>
 *
 * @method Meubles|null find($id, $lockMode = null, $lockVersion = null) // custom method to find a Meubles entity by its id
 * @method Meubles|null findOneBy(array $criteria, array $orderBy = null) // custom method to find a single Meubles entity by an array of criteria
 * @method Meubles[]    findAll() // custom method to find all Meubles entities
 * @method Meubles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) // custom method to find a list of Meubles entities by an array of criteria
 */
class MeublesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meubles::class); // call the constructor of the parent class with the registry and the Meubles class
    }

    /**
     * Custom method to save a Meubles entity to the database.
     *
     * @param Meubles $entity The Meubles entity to save.
     * @param bool    $flush  Whether to flush the changes to the database or not.
     */
    public function save(Meubles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity); // add the entity to the list of entities to be saved

        if ($flush) {
            $this->getEntityManager()->flush(); // flush the changes to the database
        }
    }

    /**
     * Custom method to remove a Meubles entity from the database.
     *
     * @param Meubles $entity The Meubles entity to remove.
     * @param bool    $flush  Whether to flush the changes to the database or not.
     */
    public function remove(Meubles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity); // remove the entity from the list of entities to be saved

        if ($flush) {
            $this->getEntityManager()->flush(); // flush the changes to the database
        }
    }
}
//    /**
//     * @return Meubles[] Returns an array of Meubles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Meubles
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
//}
