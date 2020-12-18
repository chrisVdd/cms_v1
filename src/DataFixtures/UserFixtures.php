<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends BaseFixture
{

     /**
      * @var UserPasswordEncoderInterface
      */
     private $passwordEncoder;

     /**
      * UserFixtures constructor.
      * @param UserPasswordEncoderInterface $passwordEncoder
      */
     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i) {

            /** @var User $user */
            $user = new User();

            $user->setEmail(sprintf('spacebar%d@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user, 'password')
            );
            $user->setRoles(['ROLE_USER']);

            return $user;
        });

        $this->createMany(3, 'admin_users', function($i) {

            /** @var User $user */
            $user = new User();

            $user->setEmail(sprintf('admin%d@thespacebar.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user, 'password')
            );
            $user->setRoles(['ROLE_ADMIN']);

            return $user;
        });

        $manager->flush();
    }



    // /**
    //  * @param ObjectManager $manager
    //  */
    // public function load(ObjectManager $manager)
    // {
    //     /** @var User $user */
    //     $user = new User();

    //     $user->setEmail('christina.vandd@gmail.com');
    //     $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
    //     $user->setRoles(["ROLE_ADMIN"]);

    //     $manager->persist($user);
    //     $manager->flush();
    // }
}
