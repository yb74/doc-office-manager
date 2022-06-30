<?php

namespace App\DataFixtures;

use App\Entity\Diagnostic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiagnosticFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=1; $i < 10; $i++) {
            $manager->persist(
                (new Diagnostic())
                    ->setDiagnosticDescription("This is the diagnostic description n°".$i)
                    ->setDiagnosticCreatedAt(new \DateTime())
                    ->setDiagnosticUpdatedAt(new \DateTime())
            );
        }

        $manager->flush();
    }
}
