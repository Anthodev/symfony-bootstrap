<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Common;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<EntityInterface>
 */
abstract class DoctrineBaseEntityRepository extends ServiceEntityRepository
{
    public function update(EntityInterface $entity, bool $doFlush = true): void
    {
        if ($doFlush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(EntityInterface $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function save(EntityInterface $entity, bool $doFlush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($doFlush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(EntityInterface $entity, bool $doFlush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($doFlush) {
            $this->getEntityManager()->flush();
        }
    }

    public function rollback(): void
    {
        $this->getEntityManager()->rollback();
    }

    public function refresh(EntityInterface $entity): void
    {
        $this->getEntityManager()->refresh($entity);
    }
}
