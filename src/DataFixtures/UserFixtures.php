<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Infrastructure\Persistence\Doctrine\User\Entity\Role;
use App\Infrastructure\Persistence\Doctrine\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@test.io');
        $user->setEnabled(true);
        $user->setPassword('$2y$13$crBakuxig25Tsn7bK12MOO8PAE3Es4oYJ9zoCQuzcwC1L/fx2TWsC');

        /** @var Role $adminRole */
        $adminRole = $this->getReference(RoleFixtures::ROLE_ADMIN_REFERENCE, Role::class);

        $user->setRole($adminRole);
        $manager->persist($user);

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            RoleFixtures::class,
        ];
    }
}
