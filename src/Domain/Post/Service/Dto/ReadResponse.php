<?php

declare(strict_types=1);

namespace App\Domain\Post\Service\Dto;

use App\Entity\Post;

class ReadResponse
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }
}
