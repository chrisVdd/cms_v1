<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Delete ALL the test users from DB
     */
    public function deleteTestUsers()
    {
        $this
            ->createQueryBuilder('user')
            ->delete('App:User', 'u')
            ->where('u.isTest = 1')
            ->getQuery()
            ->execute();
    }


    public function updateUserFromImport($val)
    {
        $query = $this
            ->createQueryBuilder('user')
            ->update('user')
            ->set('user.email', '')
            ->where('user.email =:email')
            ->setParameter('email', $val)
            ->getQuery()
            ->getResult();

        return $query;
    }

    public function insertUserFromImport($formData)
    {
        dd($formData);

        $query = $this
            ->createQueryBuilder('user')
            ->
    }



    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
