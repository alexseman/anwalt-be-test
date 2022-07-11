<?php

declare(strict_types=1);

namespace App\Domain\Post\Service\Dto;

use App\Shared\Exception\ValidationException;
use App\Shared\Service\HtmlTagsCleaner;
use App\Shared\Traits\ValidatorTrait;
use Symfony\Component\Validator\Constraints as Assert;

class UpdatePost
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
    private int $id;

    /**
     * @param string|null $title
     * @param string|null $body
     * @param int|null    $id
     *
     * @throws ValidationException
     */
    public function __construct(?string $title, ?string $body, ?int $id)
    {
        $this->title = $title === null ? $title : trim($title);
        $this->body  = $body === null ? $body : trim($body);
        $this->id    = $id;

        $this->validate();
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        if (null !== $this->title) {
            return HtmlTagsCleaner::clean($this->title);
        }

        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        if (null !== $this->body) {
            return HtmlTagsCleaner::clean($this->body);
        }

        return $this->body;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

}
