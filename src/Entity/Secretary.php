<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SecretaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ApiResource] => exposes all request operations
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    attributes: ["pagination_enabled" => false],
)]
#[ApiFilter(SearchFilter::class, properties: [
    'firstname' => SearchFilter::STRATEGY_PARTIAL,
    'lastname' => SearchFilter::STRATEGY_PARTIAL
])]
#[ApiFilter(OrderFilter::class, properties: ['firstname', 'lastname'], arguments: ['orderParameterName' => 'order'])]

#[ORM\Entity(repositoryClass: SecretaryRepository::class)]
class Secretary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:user', 'institution'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $staffNumber;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:user', 'institution'])]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:user', 'institution'])]
    private $lastname;

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

    #[ORM\Column(type: 'string', length: 255)]
    private $homePhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $workPhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $mobilePhoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'datetime')]
    private $secretaryCreatedAt;

    #[ORM\Column(type: 'datetime')]
    private $secretaryUpdatedAt;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\ManyToOne(targetEntity: Institution::class, inversedBy: 'secretary')]
    private $institution;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaffNumber(): ?string
    {
        return $this->staffNumber;
    }

    public function setStaffNumber(string $staffNumber): self
    {
        $this->staffNumber = $staffNumber;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSecretaryCreatedAt(): ?\DateTime
    {
        return $this->secretaryCreatedAt;
    }

    public function setSecretaryCreatedAt(\DateTime $secretaryCreatedAt): self
    {
        $this->secretaryCreatedAt = $secretaryCreatedAt;

        return $this;
    }

    public function getSecretaryUpdatedAt(): ?\DateTime
    {
        return $this->secretaryUpdatedAt;
    }

    public function setSecretaryUpdatedAt(\DateTime $secretaryUpdatedAt): self
    {
        $this->secretaryUpdatedAt = $secretaryUpdatedAt;

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
