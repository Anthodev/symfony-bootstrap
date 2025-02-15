<?php

declare(strict_types=1);

namespace App\Infrastructure\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait CodeTrait
{
    #[Assert\NotBlank, Assert\Length(min: 3, max: 32)]
    #[ORM\Column(type: Types::STRING, length: 32, unique: true)]
    private string $code;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
