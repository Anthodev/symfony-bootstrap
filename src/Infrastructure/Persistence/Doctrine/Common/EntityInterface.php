<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Common;

use Symfony\Component\Uid\Ulid;

interface EntityInterface
{
    public function getId(): ?Ulid;

    public function setId(Ulid $id): self;

    public function setDefaultId(): self;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $createdAt): self;

    public function getUpdatedAt(): ?\DateTimeInterface;

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self;
}
