<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Infrastructure\Enum\RoleCodeEnum;
use App\Infrastructure\Persistence\Doctrine\User\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const string ROLE_ADMIN_REFERENCE = 'role_admin';
    public const string ROLE_USER_REFERENCE = 'role_user';

    public function load(ObjectManager $manager): void
    {
        $adminRole = new Role();
        $adminRole->setCode(RoleCodeEnum::ROLE_ADMIN->value);
        $adminRole->setLabel('Admin');
        $manager->persist($adminRole);

        $userRole = new Role();
        $userRole->setCode(RoleCodeEnum::ROLE_USER->value);
        $userRole->setLabel('User');
        $manager->persist($userRole);

        $manager->flush();

        $this->addReference(self::ROLE_ADMIN_REFERENCE, $adminRole);
        $this->addReference(self::ROLE_USER_REFERENCE, $userRole);
    }
}
