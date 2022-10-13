<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false],
    normalizationContext: ['groups' => ['consultation']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'consultationDetails' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class, properties: ['consultation_date'], arguments: ['orderParameterName' => 'order'])]


#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['doctor', 'consultation', 'patient'])]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['doctor', 'consultation', 'patient'])]
    private $consultationDetails;

    #[ORM\Column(type: 'date')]
    #[Groups(['doctor', 'consultation', 'patient'])]
    private $consultationDate;

    #[ORM\Column(type: 'time')]
    private $startTime;

    #[ORM\Column(type: 'time')]
    private $endTime;

    #[ORM\Column(type: 'datetime')]
    private $consultationCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $consultationUpdatedAt;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'consultations')]
    private $patient;

    #[ORM\ManyToOne(targetEntity: Doctor::class, inversedBy: 'consultations')]
    private $doctor;

    #[ORM\OneToMany(mappedBy: 'consultation', targetEntity: MedicalPrescription::class)]
    #[Groups(['consultation'])]
    private $medicalPrescriptions;

    #[ORM\OneToMany(mappedBy: 'consultation', targetEntity: Diagnostic::class)]
    #[Groups(['consultation'])]
    private $diagnostics;

    public function __construct()
    {
        $this->medicalPrescriptions = new ArrayCollection();
        $this->diagnostics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsultationDetails(): ?string
    {
        return $this->consultationDetails;
    }

    public function setConsultationDetails(string $consultationDetails): self
    {
        $this->consultationDetails = $consultationDetails;

        return $this;
    }

    public function getConsultationCreatedAt(): ?\DateTimeInterface
    {
        return $this->consultationCreatedAt;
    }

    public function setConsultationCreatedAt(\DateTimeInterface $consultationCreatedAt): self
    {
        $this->consultationCreatedAt = $consultationCreatedAt;

        return $this;
    }

    public function getConsultationUpdatedAt(): ?\DateTimeInterface
    {
        return $this->consultationUpdatedAt;
    }

    public function setConsultationUpdatedAt(\DateTimeInterface $consultationUpdatedAt): self
    {
        $this->consultationUpdatedAt = $consultationUpdatedAt;

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
            $medicalPrescription->setConsultation($this);
        }

        return $this;
    }

    public function removeMedicalPrescription(MedicalPrescription $medicalPrescription): self
    {
        if ($this->medicalPrescriptions->removeElement($medicalPrescription)) {
            // set the owning side to null (unless already changed)
            if ($medicalPrescription->getConsultation() === $this) {
                $medicalPrescription->setConsultation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Diagnostic>
     */
    public function getDiagnostics(): Collection
    {
        return $this->diagnostics;
    }

    public function addDiagnostic(Diagnostic $diagnostic): self
    {
        if (!$this->diagnostics->contains($diagnostic)) {
            $this->diagnostics[] = $diagnostic;
            $diagnostic->setConsultation($this);
        }

        return $this;
    }

    public function removeDiagnostic(Diagnostic $diagnostic): self
    {
        if ($this->diagnostics->removeElement($diagnostic)) {
            // set the owning side to null (unless already changed)
            if ($diagnostic->getConsultation() === $this) {
                $diagnostic->setConsultation(null);
            }
        }

        return $this;
    }

    public function getConsultationDate(): ?\DateTimeInterface
    {
        return $this->consultationDate;
    }

    public function setConsultationDate(\DateTimeInterface $consultationDate): self
    {
        $this->consultationDate = $consultationDate;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }
}
