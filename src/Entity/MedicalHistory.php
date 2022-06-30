<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MedicalHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'medicalHistoryName' => SearchFilter::STRATEGY_PARTIAL,
    'medicalHistoryDetails' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class, properties: ['medicalHistoryName'], arguments: ['orderParameterName' => 'order'])]

#[ORM\Entity(repositoryClass: MedicalHistoryRepository::class)]
class MedicalHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $medicalHistoryName;

    #[ORM\Column(type: 'text')]
    private $medicalHistoryDetails;

    #[ORM\Column(type: 'datetime')]
    private $medicalHistoryCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $medicalHistoryUpdatedAt;

    #[ORM\Column(type: 'datetime')]
    private $medicalHistoryDate;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'medicalHistories')]
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicalHistoryName(): ?string
    {
        return $this->medicalHistoryName;
    }

    public function setMedicalHistoryName(string $medicalHistoryName): self
    {
        $this->medicalHistoryName = $medicalHistoryName;

        return $this;
    }

    public function getMedicalHistoryDetails(): ?string
    {
        return $this->medicalHistoryDetails;
    }

    public function setMedicalHistoryDetails(string $medicalHistoryDetails): self
    {
        $this->medicalHistoryDetails = $medicalHistoryDetails;

        return $this;
    }

    public function getMedicalHistoryCreatedAt(): ?\DateTimeInterface
    {
        return $this->medicalHistoryCreatedAt;
    }

    public function setMedicalHistoryCreatedAt(\DateTimeInterface $medicalHistoryCreatedAt): self
    {
        $this->medicalHistoryCreatedAt = $medicalHistoryCreatedAt;

        return $this;
    }

    public function getMedicalHistoryUpdatedAt(): ?\DateTimeInterface
    {
        return $this->medicalHistoryUpdatedAt;
    }

    public function setMedicalHistoryUpdatedAt(\DateTimeInterface $medicalHistoryUpdatedAt): self
    {
        $this->medicalHistoryUpdatedAt = $medicalHistoryUpdatedAt;

        return $this;
    }

    public function getMedicalHistoryDate(): ?\DateTimeInterface
    {
        return $this->medicalHistoryDate;
    }

    public function setMedicalHistoryDate(\DateTimeInterface $medicalHistoryDate): self
    {
        $this->medicalHistoryDate = $medicalHistoryDate;

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
