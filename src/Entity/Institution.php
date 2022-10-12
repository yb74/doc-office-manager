<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\InstitutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false],
    normalizationContext: ['groups' => ['institution']]
)]

#[ORM\Entity(repositoryClass: InstitutionRepository::class)]
class Institution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['institution'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['institution'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['institution'])]
    private $type;

    #[ORM\OneToMany(mappedBy: 'institution', targetEntity: Doctor::class)]
    #[Groups(['institution'])]
    #[ApiSubresource]
    private $doctor;

    #[ORM\OneToMany(mappedBy: 'institution', targetEntity: Secretary::class)]
    #[Groups(['institution'])]
    #[ApiSubresource]
    private $secretary;

    public function __construct()
    {
        $this->doctor = new ArrayCollection();
        $this->secretary = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Doctor>
     */
    public function getDoctor(): Collection
    {
        return $this->doctor;
    }

    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->doctor->contains($doctor)) {
            $this->doctor[] = $doctor;
            $doctor->setInstitution($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->doctor->removeElement($doctor)) {
            // set the owning side to null (unless already changed)
            if ($doctor->getInstitution() === $this) {
                $doctor->setInstitution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Secretary>
     */
    public function getSecretary(): Collection
    {
        return $this->secretary;
    }

    public function addSecretary(Secretary $secretary): self
    {
        if (!$this->secretary->contains($secretary)) {
            $this->secretary[] = $secretary;
            $secretary->setInstitution($this);
        }

        return $this;
    }

    public function removeSecretary(Secretary $secretary): self
    {
        if ($this->secretary->removeElement($secretary)) {
            // set the owning side to null (unless already changed)
            if ($secretary->getInstitution() === $this) {
                $secretary->setInstitution(null);
            }
        }

        return $this;
    }
}
