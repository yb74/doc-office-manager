<?php

namespace App\DataFixtures;

use App\Entity\Medication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedicationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $form = ["Pills", "Powder", "Capsules"];

        for ($i=1; $i < 10; $i++) {
            $manager->persist(
                (new Medication())
                    ->setMedicationName("MedicationName".$i)
                    ->setMedicationForm($form[array_rand($form)])
                    -> setMedicationDosage("1".$i." mg")
                    ->setMedicationCreatedAt(new \DateTime())
                    ->setMedicationUpdatedAt(new \DateTime())
            );
        }

        $manager->flush();
    }
}
