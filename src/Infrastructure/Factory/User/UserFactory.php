<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory\User;

use App\Infrastructure\Persistence\Doctrine\User\Entity\Role;
use App\Infrastructure\Persistence\Doctrine\User\Entity\User;

class UserFactory
{
    public static function makeUser(
        string $email,
        string $username,
        string $password,
    ): User {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPlainPassword($password);

        return $user;
    }

    public static function makeVerifiedUser(
        string $email,
        string $username,
        string $password,
    ): User {
        $user = self::makeUser($email, $username, $password);
        $user->setEnabled(true);

        return $user;
    }

    public static function makeVerifiedUserWithRole(
        string $email,
        string $username,
        string $password,
        Role $role,
    ): User {
        $user = self::makeVerifiedUser($email, $username, $password);
        $user->setRole($role);

        return $user;
    }
}
