<?php

declare(strict_types=1);

namespace App\Infrastructure\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

trait IdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(name: 'id', type: UlidType::NAME, unique: true)]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    private ?Ulid $id = null;

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function setId(Ulid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setDefaultId(): self
    {
        $this->id = new Ulid();

        return $this;
    }

    public function getIdAsUuid(): ?string
    {
        return $this->id?->toRfc4122();
    }
}
