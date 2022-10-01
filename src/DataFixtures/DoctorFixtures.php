<?php

namespace App\DataFixtures;

use App\Entity\Doctor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DoctorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 10; $i++) {
            $doctor = new Doctor();

            $doctor->setFirstname("DoctorFirstname".$i);
            $doctor->setLastname("DoctorLastname".$i);
            $doctor->setHomePhoneNumber("04 17 54 63 0".$i);
            $doctor->setWorkPhoneNumber("04 54 77 64 6".$i);
            $doctor->setMobilePhoneNumber("06 22 76 67 3".$i);
            $doctor->setEmail("doctor-email".$i."@hotmail.fr");
            $doctor->setPassword("password".$i);
            $doctor->setDoctorCreatedAt(new \DateTime());
            $doctor->setDoctorUpdatedAt(new \DateTime());

            $manager->persist($doctor);
        }
        $manager->flush();
    }
}
