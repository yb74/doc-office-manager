<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false],
    normalizationContext: ['groups' => ['patient']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'firstname' => SearchFilter::STRATEGY_PARTIAL,
    'lastname' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class, properties: ['firstname', 'lastname'], arguments: ['orderParameterName' => 'order'])]

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['doctor', 'patient'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $socialSecurityNumber;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['doctor', 'patient'])]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['doctor', 'patient'])]
    private $lastname;

    #[ORM\Column(type: 'date')]
    private $birthDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $gender;

    #[ORM\Column(type: 'string', length: 255)]
    private $maritalStatus;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $bloodType;

    #[ORM\Column(type: 'string', length: 255)]
    private $streetName;

    #[ORM\Column(type: 'string', length: 255)]
    private $streetNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $postalCode;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    private $country;

    #[ORM\Column(type: 'string', length: 255)]
    private $homePhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $workPhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $mobilePhoneNumber;

    #[ORM\Column(type: 'datetime')]
    private $patientCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $patientUpdatedAt;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Consultation::class)]
    #[Groups(['patient'])]
    private $consultations;

    #[ORM\ManyToOne(targetEntity: Doctor::class, inversedBy: 'patients')]
    private $doctor;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Medication::class)]
    #[Groups(['patient'])]
    private $medications;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: MedicalHistory::class)]
    #[Groups(['patient'])]
    private $medicalHistories;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
        $this->medications = new ArrayCollection();
        $this->medicalHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialSecurityNumber(): ?string
    {
        return $this->socialSecurityNumber;
    }

    public function setSocialSecurityNumber(string $socialSecurityNumber): self
    {
        $this->socialSecurityNumber = $socialSecurityNumber;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(string $maritalStatus): self
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBloodType(): ?string
    {
        return $this->bloodType;
    }

    public function setBloodType(string $bloodType): self
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    public function getPatientCreatedAt(): ?\DateTimeInterface
    {
        return $this->patientCreatedAt;
    }

    public function setPatientCreatedAt(\DateTimeInterface $patientCreatedAt): self
    {
        $this->patientCreatedAt = $patientCreatedAt;

        return $this;
    }

    public function getPatientUpdatedAt(): ?\DateTimeInterface
    {
        return $this->patientUpdatedAt;
    }

    public function setPatientUpdatedAt(\DateTimeInterface $patientUpdatedAt): self
    {
        $this->patientUpdatedAt = $patientUpdatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * @return Collection<int, Medication>
     */
    public function getMedications(): Collection
    {
        return $this->medications;
    }

    public function addMedication(Medication $medication): self
    {
        if (!$this->medications->contains($medication)) {
            $this->medications[] = $medication;
            $medication->setPatient($this);
        }

        return $this;
    }

    public function removeMedication(Medication $medication): self
    {
        if ($this->medications->removeElement($medication)) {
            // set the owning side to null (unless already changed)
            if ($medication->getPatient() === $this) {
                $medication->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedicalHistory>
     */
    public function getMedicalHistories(): Collection
    {
        return $this->medicalHistories;
    }

    public function addMedicalHistory(MedicalHistory $medicalHistory): self
    {
        if (!$this->medicalHistories->contains($medicalHistory)) {
            $this->medicalHistories[] = $medicalHistory;
            $medicalHistory->setPatient($this);
        }

        return $this;
    }

    public function removeMedicalHistory(MedicalHistory $medicalHistory): self
    {
        if ($this->medicalHistories->removeElement($medicalHistory)) {
            // set the owning side to null (unless already changed)
            if ($medicalHistory->getPatient() === $this) {
                $medicalHistory->setPatient(null);
            }
        }

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getHomePhoneNumber(): ?string
    {
        return $this->homePhoneNumber;
    }

    public function setHomePhoneNumber(string $homePhoneNumber): self
    {
        $this->homePhoneNumber = $homePhoneNumber;

        return $this;
    }

    public function getWorkPhoneNumber(): ?string
    {
        return $this->workPhoneNumber;
    }

    public function setWorkPhoneNumber(string $workPhoneNumber): self
    {
        $this->workPhoneNumber = $workPhoneNumber;

        return $this;
    }

    public function getMobilePhoneNumber(): ?string
    {
        return $this->mobilePhoneNumber;
    }

    public function setMobilePhoneNumber(string $mobilePhoneNumber): self
    {
        $this->mobilePhoneNumber = $mobilePhoneNumber;

        return $this;
    }
}
