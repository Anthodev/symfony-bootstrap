<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\User\Repository;

use App\Infrastructure\Persistence\Doctrine\Common\DoctrineBaseEntityRepository;
use App\Infrastructure\Persistence\Doctrine\User\Entity\Role;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineRoleRepository extends DoctrineBaseEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }
}
