<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $userRoles = ["ROLE_DOCTOR", "ROLE_SECRETARY"];
        for ($i=1; $i < 10; $i++) {
            $manager->persist(
                (new User())
                    ->setLogin("myUserLogin".$i)
                    ->setPassword("myPassword".$i)
                    ->setRoles([$userRoles[array_rand($userRoles)]]) // Randomly setting a role to the created user
            );
        }

        $manager->flush();
    }
}
