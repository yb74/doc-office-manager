<?php

namespace App\DataFixtures;

use App\Entity\Institution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InstitutionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $institutionType = ["Hospital", "Medical center", "Radiology"];
        for ($i=1; $i < 10; $i++) {
            $manager->persist(
                (new Institution())
                    ->setType($institutionType[array_rand($institutionType)])
                    ->setName("Institution name" . $i)
//                    ->addDoctor($doctor)
//                    ->addSecretary($secretary)
            );
        }

        $manager->flush();
    }
}
