<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

use App\Repository\DoctorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false],
    normalizationContext: ['groups' => ['doctor']]
)]

#[ApiFilter(SearchFilter::class, properties: [
    'firstname' => SearchFilter::STRATEGY_PARTIAL,
    'lastname' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class, properties: ['firstname', 'lastname'], arguments: ['orderParameterName' => 'order'])]

#[ORM\Entity(repositoryClass: DoctorRepository::class)]

class Doctor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:user', 'institution', 'doctor'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $rppsNumber;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:user', 'institution', 'doctor'])]
    #[NotBlank]
    #[Length(min: 3)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:user', 'institution', 'doctor'])]
    #[Assert\NotIdenticalTo(propertyPath: "firstname")]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $homePhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $workPhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $mobilePhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $gender;

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

    #[ORM\Column(type: 'datetime')]
    private $doctorCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $doctorUpdatedAt;

    #[ORM\OneToMany(mappedBy: 'doctor', targetEntity: Consultation::class)]
    #[Groups(['doctor'])]
    private $consultations;

    #[ORM\OneToMany(mappedBy: 'doctor', targetEntity: Patient::class)]
    #[Groups(['doctor'])]
    #[ApiSubresource]
    private $patients;

    #[ORM\OneToMany(mappedBy: 'doctor', targetEntity: MedicalPrescription::class)]
    #[Groups(['doctor'])]
    private $medicalPrescriptions;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\ManyToOne(targetEntity: Institution::class, inversedBy: 'doctor')]
    private $institution;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
        $this->patients = new ArrayCollection();
        $this->medicalPrescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDoctorCreatedAt(): ?\DateTimeInterface
    {
        return $this->doctorCreatedAt;
    }

    public function setDoctorCreatedAt(\DateTimeInterface $doctorCreatedAt): self
    {
        $this->doctorCreatedAt = $doctorCreatedAt;

        return $this;
    }

    public function getDoctorUpdatedAt(): ?\DateTimeInterface
    {
        return $this->doctorUpdatedAt;
    }

    public function setDoctorUpdatedAt(\DateTimeInterface $doctorUpdatedAt): self
    {
        $this->doctorUpdatedAt = $doctorUpdatedAt;

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
            $consultation->setDoctor($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getDoctor() === $this) {
                $consultation->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setDoctor($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getDoctor() === $this) {
                $patient->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedicalPrescription>
     */
    public function getMedicalPrescriptions(): Collection
    {
        return $this->medicalPrescriptions;
    }

    public function addMedicalPrescription(MedicalPrescription $medicalPrescription): self
    {
        if (!$this->medicalPrescriptions->contains($medicalPrescription)) {
            $this->medicalPrescriptions[] = $medicalPrescription;
            $medicalPrescription->setDoctor($this);
        }

        return $this;
    }

    public function removeMedicalPrescription(MedicalPrescription $medicalPrescription): self
    {
        if ($this->medicalPrescriptions->removeElement($medicalPrescription)) {
            // set the owning side to null (unless already changed)
            if ($medicalPrescription->getDoctor() === $this) {
                $medicalPrescription->setDoctor(null);
            }
        }

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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

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

    public function getRppsNumber(): ?string
    {
        return $this->rppsNumber;
    }

    public function setRppsNumber(string $rppsNumber): self
    {
        $this->rppsNumber = $rppsNumber;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): self
    {
        $this->institution = $institution;

        return $this;
    }
}
