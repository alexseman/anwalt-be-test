<?php

declare(strict_types=1);

namespace App\Domain\Todo\Service\Dto;

use App\Shared\Exception\ValidationException;
use App\Shared\Service\HtmlTagsCleaner;
use App\Shared\Traits\ValidatorTrait;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTodo
{
    use ValidatorTrait;

    /**
     * @Assert\NotBlank()
     */
    private string $title;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Shared\Enum\TodoStatusEnum", "choices"})
     */
    private string $status;

    /**
     * @Assert\NotBlank()
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private string $dueOn;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private int $userId;

    /**
     * @param string|null $title
     * @param string|null $dueOn
     * @param string|null $status
     * @param int|null    $userId
     *
     * @throws ValidationException
     */
    public function __construct(?string $title, ?string $dueOn, ?string $status, ?int $userId)
    {
        $this->title  = $title === null ? $title : trim($title);
        $this->dueOn  = $dueOn === null ? $dueOn : trim($dueOn);
        $this->status = $status === null ? $status : trim($status);
        $this->userId = $userId;

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
    public function getStatus(): ?string
    {
        if (null !== $this->status) {
            return HtmlTagsCleaner::clean($this->status);
        }

        return $this->status;
    }

    /**
     * @return string
     */
    public function getDueOn(): ?string
    {
        if (null !== $this->dueOn) {
            return HtmlTagsCleaner::clean($this->dueOn);
        }

        return $this->dueOn;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

}
