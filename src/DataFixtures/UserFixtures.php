<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i=0; $i < 100; $i++) {
            $user = new User();
            $user->setLogin($faker->name);//jjjjjjj
            $user->setFirstname($faker->firstName);
            $user->setName($faker->name);
            $user->setPassword($faker->name);//jjjjjjj
            $user->setRole($faker->name);//jjjjjjjj
            $user->setMail($faker->name);//GG
            // RESTE LES CREATEDAT ET AUTRES
            // apres faire symfony console doctrine:fixture:load --append
            $user->setAge($faker->numberBetween(18, 65));

            $manager->persist($user);
        }
        $manager->flush();
    }
}
