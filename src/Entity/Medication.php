<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MedicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'medicationName' => SearchFilter::STRATEGY_PARTIAL,
    'medicationDosage' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class, properties: ['medicationName'], arguments: ['orderParameterName' => 'order'])]

#[ORM\Entity(repositoryClass: MedicationRepository::class)]
class Medication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['patient', 'medicalPrescription'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[NotBlank]
    #[Length(min: 3)]
    #[Groups(['patient', 'medicalPrescription'])]
    private $medicationName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['patient', 'medicalPrescription'])]
    private $medicationDosage;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['patient', 'medicalPrescription'])]
    private $medicationForm;

    #[ORM\Column(type: 'datetime')]
    private $medicationCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $medicationUpdatedAt;

    #[ORM\ManyToOne(targetEntity: MedicalPrescription::class, inversedBy: 'medications')]
    private $medicalPrescription;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'medications')]
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicationName(): ?string
    {
        return $this->medicationName;
    }

    public function setMedicationName(string $medicationName): self
    {
        $this->medicationName = $medicationName;

        return $this;
    }

    public function getMedicationDosage(): ?string
    {
        return $this->medicationDosage;
    }

    public function setMedicationDosage(string $medicationDosage): self
    {
        $this->medicationDosage = $medicationDosage;

        return $this;
    }

    public function getMedicationForm(): ?string
    {
        return $this->medicationForm;
    }

    public function setMedicationForm(string $medicationForm): self
    {
        $this->medicationForm = $medicationForm;

        return $this;
    }

    public function getMedicationCreatedAt(): ?\DateTimeInterface
    {
        return $this->medicationCreatedAt;
    }

    public function setMedicationCreatedAt(\DateTimeInterface $medicationCreatedAt): self
    {
        $this->medicationCreatedAt = $medicationCreatedAt;

        return $this;
    }

    public function getMedicationUpdatedAt(): ?\DateTimeInterface
    {
        return $this->medicationUpdatedAt;
    }

    public function setMedicationUpdatedAt(\DateTimeInterface $medicationUpdatedAt): self
    {
        $this->medicationUpdatedAt = $medicationUpdatedAt;

        return $this;
    }

    public function getMedicalPrescription(): ?MedicalPrescription
    {
        return $this->medicalPrescription;
    }

    public function setMedicalPrescription(?MedicalPrescription $medicalPrescription): self
    {
        $this->medicalPrescription = $medicalPrescription;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
