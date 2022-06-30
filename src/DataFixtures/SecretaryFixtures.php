<?php

namespace App\DataFixtures;

use App\Entity\Secretary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SecretaryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 10; $i++) {
            $gender = ["Male", "Female"];

            $secretary = new Secretary();

            $secretary->setStaffNumber("36548".$i);
            $secretary->setFirstname("SecretaryFirstname".$i);
            $secretary->setLastname("SecretaryLastname".$i);
            $secretary->setGender($gender[array_rand($gender)]);
            $secretary->setStreetNumber("1".$i);
            $secretary->setStreetName("impasse des bois");
            $secretary->setPostalCode("75000");
            $secretary->setCity("Paris");
            $secretary->setCountry("France");
            $secretary->setHomePhoneNumber("04 60 69 48 2".$i);
            $secretary->setWorkPhoneNumber("06 47 65 11 5".$i);
            $secretary->setMobilePhoneNumber("06 11 47 36 2".$i);
            $secretary->setEmail("secretary-email".$i."@hotmail.fr");
            $secretary->setSecretaryCreatedAt(new \DateTime());
            $secretary->setSecretaryUpdatedAt(new \DateTime());

            $manager->persist($secretary);
        }
        $manager->flush();
    }
}
