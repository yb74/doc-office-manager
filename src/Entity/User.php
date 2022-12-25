<?php

namespace App\Entity;

use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

use App\Controller\MeController;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        'get' => [
            'controller' => NotFoundAction::class,
            'openapi_context' => ['summary' => 'hidden'],
            'read' => false,
            'output' => false
        ],
        'me' => [
            'pagination_enabled' => false,
            'path' => '/me',
            'method' => 'get',
            'controller' => MeController::class,
            'read' => false,
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ]
        ], 'put', 'delete'
    ],
    attributes: ["pagination_enabled" => false],
    normalizationContext: ['groups' => ['read:user']],
    security: 'is_granted("ROLE_USER")'
)]

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:user'])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['read:user'])]
    #[NotBlank]
    #[Length(min: 3)]
    private $login;

    #[ORM\Column(type: 'json')]
    #[Groups(['read:user'])]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Doctor::class, cascade: ['persist', 'remove'])]
    #[Groups(['read:user'])]
    #[ApiSubresource]
    private $doctor;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Secretary::class, cascade: ['persist', 'remove'])]
    #[Groups('read:user')]
    #[ApiSubresource]
    private $secretary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        // unset the owning side of the relation if necessary
        if ($doctor === null && $this->doctor !== null) {
            $this->doctor->setUserId(null);
        }

        // set the owning side of the relation if necessary
        if ($doctor !== null && $doctor->getUserId() !== $this) {
            $doctor->setUserId($this);
        }

        $this->doctor = $doctor;

        return $this;
    }

    public function getSecretary(): ?Secretary
    {
        return $this->secretary;
    }

    public function setSecretary(?Secretary $secretary): self
    {
        // unset the owning side of the relation if necessary
        if ($secretary === null && $this->secretary !== null) {
            $this->secretary->setUserId(null);
        }

        // set the owning side of the relation if necessary
        if ($secretary !== null && $secretary->getUserId() !== $this) {
            $secretary->setUserId($this);
        }

        $this->secretary = $secretary;

        return $this;
    }

    public static function createFromPayload($id, array $payload)
    {
        $user = new User();
        $user->setId($id);
        $user->setLogin($payload['login'] ?? '');

        return $user;
    }
}
