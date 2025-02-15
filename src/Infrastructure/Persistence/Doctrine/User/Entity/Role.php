<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\User\Entity;

use App\Infrastructure\Persistence\Doctrine\Common\EntityInterface;
use App\Infrastructure\Persistence\Doctrine\User\Repository\DoctrineRoleRepository;
use App\Infrastructure\Trait\CodeTrait;
use App\Infrastructure\Trait\IdTrait;
use App\Infrastructure\Trait\LabelTrait;
use App\Infrastructure\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DoctrineRoleRepository::class)]
#[ORM\Table(name: 'roles')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['code'], message: 'This code is already used.')]
#[UniqueEntity(fields: ['label'], message: 'This label is already used.')]
class Role implements EntityInterface
{
    use IdTrait;
    use LabelTrait;
    use CodeTrait;
    use TimestampableTrait;

    /**
     * @var Collection<int, User> $users
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'role')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }
}
