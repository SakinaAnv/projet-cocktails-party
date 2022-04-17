<?php

namespace App\DataFixtures;

use App\Entity\Table;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TableFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i<6;$i++) {
            $table = new Table();
            $table->setAccessibility(true);
            $manager->persist($table);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['table'];
    }
}
