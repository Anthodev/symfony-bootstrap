<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Domain\Model\User\Role;
use App\Domain\Model\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = new User(
            email: 'admin@test.io',
            username: 'admin',
            password: '$2y$13$crBakuxig25Tsn7bK12MOO8PAE3Es4oYJ9zoCQuzcwC1L/fx2TWsC',
            enabled: true,
        );

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
