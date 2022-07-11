<?php

declare(strict_types=1);

namespace App\Domain\Todo\Service\Dto;

use App\Shared\Exception\ValidationException;
use App\Shared\Service\HtmlTagsCleaner;
use App\Shared\Traits\ValidatorTrait;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateTodo
{
    use ValidatorTrait;

    /**
     * @Assert\NotBlank()
     */
    private string $title;

    /**
     * @Assert\NotBlank()
//     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private string $dueOn;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Shared\Enum\TodoStatusEnum", "choices"})
     */
    private string $status;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private int $id;

    /**
     * @param string|null $title
     * @param string|null $dueOn
     * @param string|null $status
     * @param int|null    $id
     *
     * @throws ValidationException
     */
    public function __construct(?string $title, ?string $dueOn, ?string $status, ?int $id)
    {
        $this->title  = $title === null ? $title : trim($title);
        $this->status = $status === null ? $status : trim($status);
        $this->dueOn  = $dueOn === null ? $dueOn : trim($dueOn);
        $this->id     = $id;

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
    public function getId(): ?int
    {
        return $this->id;
    }

}
