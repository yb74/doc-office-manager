<?php

namespace App\DataFixtures;

use App\Entity\MedicalPrescription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedicalPrescriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=1; $i < 10; $i++) {
            $manager->persist(
                (new MedicalPrescription())
                    ->setMedicalPrescriptionDescription("This is the medical prescription element n°".$i)
                    ->setMedicalPrescriptionCreatedAt(new \DateTime())
                    ->setMedicalPrescriptionUpdatedAt(new \DateTime())
            );
        }

        $manager->flush();
    }
}
