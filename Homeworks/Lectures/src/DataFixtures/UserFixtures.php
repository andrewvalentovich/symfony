<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function (User $user) {
           $user
               ->setEmail($this->faker->email)
               ->setFirstName($this->faker->firstName)
               ->setPassword('123')
           ;
        });
    }
}
