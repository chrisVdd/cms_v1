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

    public function deleteTestUsers()
    {
        $deletableUserIds = $this
            ->createQueryBuilder('user')
//            ->select('user.id')
            ->innerJoin('user.posts', 'post')
//            ->andWhere('p.author = :user.id')
            ->andWhere('user.isTest = 1')
            ->getQuery()
            ->getResult();

        $test = $this
            ->createQueryBuilder('user')
            ->where('user.id in (:ids)')
            ->setParameter('ids', $deletableUserIds)
            ->delete()
            ->getQuery()
            ->getResult();

        dd($deletableUserIds, $test);
//            ->execute();
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
