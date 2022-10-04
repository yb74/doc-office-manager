<?php

namespace App\DataFixtures;

use App\Entity\Consultation;
use App\Entity\Diagnostic;
use App\Entity\Doctor;
use App\Entity\Institution;
use App\Entity\MedicalHistory;
use App\Entity\MedicalPrescription;
use App\Entity\Medication;
use App\Entity\Patient;
use App\Entity\Secretary;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $gender = ["Male", "Female"];
        $institutionType = ["Hospital", "Medical center", "Radiology"];
        $maritalStatus = ["Single", "Married", "divorced"];
        $bloodType = ["O-", "O+", "AB+"];
        $userRoles = ["ROLE_DOCTOR", "ROLE_SECRETARY"];

        for ($i=1; $i < 10; $i++) {
            // Instantiate entities
            $user = new User();
            $institution = new Institution();
            $doctor = new Doctor();
            $secretary = new Secretary();
            $patient = new Patient();
            $medicalPrescription = new MedicalPrescription();
            $medication = new Medication();
            $consultation = new Consultation();
            $medicalHistory = new MedicalHistory();
            $diagnostic = new Diagnostic();

            // Users
            $user->setLogin("myLogin".$i);
            $user->setPassword("myPassword".$i);
            $user->setRoles([$userRoles[array_rand($userRoles)]]); // Randomly setting a role to the created user
            $user->setDoctor($doctor);

            if(in_array('ROLE_DOCTOR', $user->getRoles())) {
                $user->setDoctor($doctor);
            } else if(in_array('ROLE_SECRETARY', $user->getRoles())) {
                $user->setSecretary($secretary);
            }

            $manager->persist($user);

            // Institution
            $institution->setName("Institution name" . $i);
            $institution->setType($institutionType[array_rand($institutionType)]);
            $institution->addDoctor($doctor);
            $institution->addSecretary($secretary);

            $manager->persist($institution);

            // Doctors
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

            // Secretaries
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

            // Patients
            $doctor->addPatient($patient);

            $patient->setSocialSecurityNumber("1 92 11 75 015 075 5".$i);
            $patient->setFirstname("PatientFirstname".$i);
            $patient->setLastname("PatientLastname".$i);
            $patient->setBirthDate(\DateTime::createFromFormat('Y-m-d', '199'.$i.'-11-15'));
            $patient->setGender($gender[array_rand($gender)]);
            $patient->setMaritalStatus($maritalStatus[array_rand($maritalStatus)]);
            $patient->setStreetNumber("1".$i);
            $patient->setStreetName("Rue de la liberté");
            $patient->setPostalCode("75000");
            $patient->setCity("Paris");
            $patient->setCountry("France");
            $patient->setHomePhoneNumber("04 50 48 65 5".$i);
            $patient->setWorkPhoneNumber("06 65 22 14 8".$i);
            $patient->setMobilePhoneNumber("06 17 54 63 0".$i);
            $patient->setEmail("my-email".$i."@hotmail.fr");
            $patient->setBloodType($bloodType[array_rand($bloodType)]);
            $patient->setPatientCreatedAt(new \DateTime());
            $patient->setPatientUpdatedAt(new \DateTime());

            $manager->persist($patient);

            // Medical prescription
            $doctor->addMedicalPrescription($medicalPrescription);
            $consultation->addMedicalPrescription($medicalPrescription);

            $medicalPrescription->setMedicalPrescriptionDescription("This is the medical prescription element n°".$i);
            $medicalPrescription->setMedicalPrescriptionCreatedAt(new \DateTime());
            $medicalPrescription->setMedicalPrescriptionUpdatedAt(new \DateTime());

            $manager->persist($medicalPrescription);

            // Medication
            $medicationForm = ["Pills", "Powder", "Capsules"];

            $patient->addMedication($medication);
            $medicalPrescription->addMedication($medication);

            $medication->setMedicationName("MedicationName".$i);
            $medication->setMedicationForm($medicationForm[array_rand($medicationForm)]);
            $medication-> setMedicationDosage("1".$i." mg");
            $medication->setMedicationCreatedAt(new \DateTime());
            $medication->setMedicationUpdatedAt(new \DateTime());

            $manager->persist($medication);

            // Consultations
            $doctor->addConsultation($consultation);
            $patient->addConsultation($consultation);
            $medicalPrescription->addMedication($medication);

            $consultation->setConsultationDate(\DateTime::createFromFormat('Y-m-d', '2022-11-1'.$i));
            $consultation->setConsultationDetails("This is the consultation details n°".$i);
            $consultation->setConsultationCreatedAt(new \DateTime());
            $consultation->setConsultationUpdatedAt(new \DateTime());
            $consultation->setStartTime(new \DateTime('14:00'));
            $consultation->setEndTime(new \DateTime('18:00'));

            $manager->persist($consultation);

            // Medical History
            $patient->addMedicalHistory($medicalHistory);

            $medicalHistory->setMedicalHistoryName("MedicalHistoryName".$i);
            $medicalHistory->setMedicalHistoryDate(\DateTime::createFromFormat('Y-m-d', '201'.$i.'-11-15'));
            $medicalHistory->setMedicalHistoryDetails("This is the medical history element n°".$i);
            $medicalHistory->setMedicalHistoryCreatedAt(new \DateTime());
            $medicalHistory->setMedicalHistoryUpdatedAt(new \DateTime());

            $manager->persist($medicalHistory);

            // Diagnostic
            $consultation->addDiagnostic($diagnostic);

            $diagnostic->setDiagnosticDescription("This is the diagnostic description n°".$i);
            $diagnostic->setDiagnosticCreatedAt(new \DateTime());
            $diagnostic->setDiagnosticUpdatedAt(new \DateTime());

            $manager->persist($diagnostic);
        }
        $manager->flush();
    }
}
