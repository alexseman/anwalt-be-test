<?php

declare(strict_types=1);

namespace App\Tests\Smoke\Traits;

use App\Entity\User;

trait UserCreatorTrait
{

    /**
     * @param int $userId
     *
     * @return User
     */
    public function createUser(int $userId): User
    {
        return new User($userId);
    }
}
