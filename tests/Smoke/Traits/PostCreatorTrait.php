<?php

declare(strict_types=1);

namespace App\Tests\Smoke\Traits;

use App\Entity\Post;
use App\Entity\User;

trait PostCreatorTrait
{

    /**
     * @param string $title
     * @param string $body
     * @param User   $user
     *
     * @return Post
     */
    public function createPost(string $title, string $body, User $user): Post
    {
        return new Post($title, $body, $user);
    }
}
