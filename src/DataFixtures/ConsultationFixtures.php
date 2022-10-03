<?php

namespace App\DataFixtures;

use App\Entity\Consultation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConsultationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 10; $i++) {
            $manager->persist(
                (new Consultation())
                    ->setConsultationDate(\DateTime::createFromFormat('Y-m-d', '2022-11-1'.$i))
                    ->setConsultationDetails("This is the consultation details n°".$i)
                    ->setConsultationCreatedAt(new \DateTime())
                    ->setConsultationUpdatedAt(new \DateTime())
                    ->setStartTime(new \DateTime('14:00'))
                    ->setEndTime(new \DateTime('18:00'))
            );
        }

        $manager->flush();
    }
}
