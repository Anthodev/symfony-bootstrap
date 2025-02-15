<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Persistence\Doctrine\Common\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class EntityListener
{
    public function prePersist(PrePersistEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        if (!$entity instanceof EntityInterface) {
            return;
        }

        $entity->setCreatedAt(new \DateTimeImmutable());
        $entity->setUpdatedAt(new \DateTime());
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        if (!$entity instanceof EntityInterface) {
            return;
        }

        $entity->setUpdatedAt(new \DateTime());
    }
}
