<?php

declare(strict_types=1);

namespace App\Domain\Post\Service\Dto;

use App\Shared\Exception\ValidationException;
use App\Shared\Traits\ValidatorTrait;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePost
{
    use ValidatorTrait;

    /**
     * @Assert\NotBlank()
     */
    private string $title;

    /**
     * @Assert\NotBlank()
     */
    private string $body;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private int $userId;

    /**
     * @param string|null $title
     * @param string|null $body
     * @param int|null    $userId
     *
     * @throws ValidationException
     */
    public function __construct(?string $title, ?string $body, ?int $userId)
    {
        $this->title  = $title;
        $this->body   = $body;
        $this->userId = $userId;

        $this->validate();
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }
}
