<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MedicalPrescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false],
    normalizationContext: ['groups' => ['medicalPrescription']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'medicalPrescriptionDescription' => SearchFilter::STRATEGY_PARTIAL,
])]
#[ApiFilter(OrderFilter::class, properties: ['medicalPrescriptionDescription', 'medicalPrescriptionCreatedAt','medicalPrescriptionUpdatedAt'], arguments: ['orderParameterName' => 'order'])]

#[ORM\Entity(repositoryClass: MedicalPrescriptionRepository::class)]
class MedicalPrescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['doctor', 'medicalPrescription', 'consultation'])]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['doctor', 'medicalPrescription', 'consultation'])]
    private $medicalPrescriptionDescription;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['doctor', 'medicalPrescription', 'consultation'])]
    private $medicalPrescriptionCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $medicalPrescriptionUpdatedAt;

    #[ORM\ManyToOne(targetEntity: Consultation::class, inversedBy: 'medical_prescriptions')]
    private $consultation;

    #[ORM\OneToMany(mappedBy: 'medicalPrescription', targetEntity: Medication::class)]
    #[Groups(['medicalPrescription'])]
    private $medications;

    #[ORM\ManyToOne(targetEntity: Doctor::class, inversedBy: 'medicalPrescriptions')]
    private $doctor;

    public function __construct()
    {
        $this->medications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicalPrescriptionDescription(): ?string
    {
        return $this->medicalPrescriptionDescription;
    }

    public function setMedicalPrescriptionDescription(string $medicalPrescriptionDescription): self
    {
        $this->medicalPrescriptionDescription = $medicalPrescriptionDescription;

        return $this;
    }

    public function getMedicalPrescriptionCreatedAt(): ?\DateTimeInterface
    {
        return $this->medicalPrescriptionCreatedAt;
    }

    public function setMedicalPrescriptionCreatedAt(\DateTimeInterface $medicalPrescriptionCreatedAt): self
    {
        $this->medicalPrescriptionCreatedAt = $medicalPrescriptionCreatedAt;

        return $this;
    }

    public function getMedicalPrescriptionUpdatedAt(): ?\DateTimeInterface
    {
        return $this->medicalPrescriptionUpdatedAt;
    }

    public function setMedicalPrescriptionUpdatedAt(\DateTimeInterface $medicalPrescriptionUpdatedAt): self
    {
        $this->medicalPrescriptionUpdatedAt = $medicalPrescriptionUpdatedAt;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): self
    {
        $this->consultation = $consultation;

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
            $medication->setMedicalPrescription($this);
        }

        return $this;
    }

    public function removeMedication(Medication $medication): self
    {
        if ($this->medications->removeElement($medication)) {
            // set the owning side to null (unless already changed)
            if ($medication->getMedicalPrescription() === $this) {
                $medication->setMedicalPrescription(null);
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
}
