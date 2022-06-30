<?php

namespace App\DataFixtures;

use App\Entity\MedicalHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedicalHistoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=1; $i < 10; $i++) {
            $manager->persist(
                (new MedicalHistory())
                    ->setMedicalHistoryName("MedicalHistoryName".$i)
                    ->setMedicalHistoryDate(\DateTime::createFromFormat('Y-m-d', '201'.$i.'-11-15'))
                    ->setMedicalHistoryDetails("This is the medical history element n°".$i)
                    ->setMedicalHistoryCreatedAt(new \DateTime())
                    ->setMedicalHistoryUpdatedAt(new \DateTime())
            );
        }

        $manager->flush();
    }
}
