<?php

namespace App\DataFixtures;

use App\Entity\Doctor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DoctorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $gender = ["Male", "Female"];
        for ($i=1; $i < 10; $i++) {
            $doctor = new Doctor();

            // Doctors

            // $secretary->addDoctor($doctor);

            $doctor->setRppsNumber("14569".$i);
            $doctor->setFirstname("DoctorFirstname".$i);
            $doctor->setLastname("DoctorLastname".$i);
            $doctor->setGender($gender[array_rand($gender)]);
            $doctor->setStreetNumber("1".$i);
            $doctor->setStreetName("Avenue des lilas");
            $doctor->setPostalCode("75000");
            $doctor->setCity("Paris");
            $doctor->setCountry("France");
            $doctor->setHomePhoneNumber("04 60 69 48 2".$i);
            $doctor->setWorkPhoneNumber("06 47 65 11 5".$i);
            $doctor->setMobilePhoneNumber("06 11 47 36 2".$i);
            $doctor->setEmail("doctor-email".$i."@hotmail.fr");
            $doctor->setDoctorCreatedAt(new \DateTime());
            $doctor->setDoctorUpdatedAt(new \DateTime());

            $manager->persist($doctor);
        }
        $manager->flush();
    }
}
