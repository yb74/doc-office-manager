<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DiagnosticRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'diagnosticDescription' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class, properties: ['diagnosticCreatedAt'], arguments: ['orderParameterName' => 'order'])]

#[ORM\Entity(repositoryClass: DiagnosticRepository::class)]
class Diagnostic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['consultation'])]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['consultation'])]
    private $diagnosticDescription;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['consultation'])]
    private $diagnosticCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $diagnosticUpdatedAt;

    #[ORM\ManyToOne(targetEntity: Consultation::class, inversedBy: 'diagnostics')]
    private $consultation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiagnosticDescription(): ?string
    {
        return $this->diagnosticDescription;
    }

    public function setDiagnosticDescription(string $diagnosticDescription): self
    {
        $this->diagnosticDescription = $diagnosticDescription;

        return $this;
    }

    public function getDiagnosticCreatedAt(): ?\DateTimeInterface
    {
        return $this->diagnosticCreatedAt;
    }

    public function setDiagnosticCreatedAt(\DateTimeInterface $diagnosticCreatedAt): self
    {
        $this->diagnosticCreatedAt = $diagnosticCreatedAt;

        return $this;
    }

    public function getDiagnosticUpdatedAt(): ?\DateTimeInterface
    {
        return $this->diagnosticUpdatedAt;
    }

    public function setDiagnosticUpdatedAt(\DateTimeInterface $diagnosticUpdatedAt): self
    {
        $this->diagnosticUpdatedAt = $diagnosticUpdatedAt;

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
}
