<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

abstract class BaseFixtures extends Fixture
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var ObjectManager
     */
    protected $manager;


    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        $this->loadData($manager);
    }

    abstract function loadData(ObjectManager $manager);

    protected function create(string $classNmae, callable $factory)
    {
        $entity = new $classNmae;
        $factory($entity);
        $this->manager->persist($entity);

        return $entity;
    }

    protected function createMany(string $classNmae, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->create($classNmae, $factory);
        }

        $this->manager->flush();
    }
}
