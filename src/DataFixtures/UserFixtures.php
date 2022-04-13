<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {


            // apres faire symfony console doctrine:fixture:load --append --group=nomgroup

        /////////
        $faker = Factory::create('fr_FR');

        $admin1 = new User();
        $admin1->setFirstname($faker->firstName);
        $admin1->setName($faker->name);
        $admin1->setEmail('admin1@gmail.com');
        $admin1->setPassword($this->hasher->hashPassword($admin1,'admin1'));
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin1->setCreatedAt($faker->dateTime);


        $admin2 = new User();
        $admin2->setFirstname($faker->firstName);
        $admin2->setName($faker->lastName);
        $admin2->setEmail('admin2@gmail.com');
        $admin2->setPassword($this->hasher->hashPassword($admin2, 'admin2'));
        $admin2->setRoles(['ROLE_ADMIN']);
        $admin2->setCreatedAt($faker->dateTime);

        $manager->persist($admin1);
        $manager->persist($admin2);

        for ($i=0; $i < 100; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setName($faker->name);
            $user->setCreatedAt($faker->dateTime);
            $user->setUpdatedAt(new \DateTime());
            $user->setEmail($faker->freeEmail);
            if ($i % 2 == 0){
                $user->setRoles(['ROLE_STAFF']);
            }else{
                $user->setRoles(['ROLE_CLIENT']);
            }
            $user->setPassword($this->hasher->hashPassword($user,'user'));
            $manager->persist($user);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
