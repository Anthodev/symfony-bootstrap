<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\User\Entity;

use App\Infrastructure\Persistence\Doctrine\Common\EntityInterface;
use App\Infrastructure\Persistence\Doctrine\User\Repository\DoctrineUserRepositoryDoctrine;
use App\Infrastructure\Trait\IdTrait;
use App\Infrastructure\Trait\TimestampableTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DoctrineUserRepositoryDoctrine::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'This email is already used.')]
#[UniqueEntity(fields: ['username'], message: 'This username is already used.')]
class User implements EntityInterface, UserInterface, PasswordAuthenticatedUserInterface
{
    use IdTrait;
    use TimestampableTrait;

    #[Assert\NotBlank, Assert\Email]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $email;

    #[Assert\NotBlank, Assert\Length(min: 3, max: 255)]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $username;

    #[Assert\Length(min: 12, max: 255, minMessage: 'Your password must be at least {{ limit }} characters long.')]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $password;

    #[Assert\Length(min: 12, max: 255, minMessage: 'Your password must be at least {{ limit }} characters long.'), Assert\PasswordStrength]
    private ?string $plainPassword;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $enabled = false;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    private Role $role;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles(): array
    {
        /** @var string $roleCode */
        $roleCode = $this->role->getCode();

        return [$roleCode];
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->getEmail();
    }
}
