<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function (User $user) {
           $user
               ->setEmail($this->faker->email)
               ->setFirstName($this->faker->firstName)
               ->setPassword($this->userPasswordEncoder->encodePassword($user, '123'))
           ;
        });
    }
}
