<?php

declare(strict_types=1);

namespace App\Domain\Todo\Service\Dto;

use App\Shared\Exception\ValidationException;
use App\Shared\Service\HtmlTagsCleaner;
use App\Shared\Traits\ValidatorTrait;
use Symfony\Component\Validator\Constraints as Assert;

class ByUserTodo
{
    use ValidatorTrait;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private int $userId;

    /**
     * @var string|null
     */
    private ?string $title;

    /**
     * @var string|null
     */
    private ?string $dueOn;

    /**
     * @var string|null
     */
    private ?string $status;

    /**
     * @Assert\Choice({0, 1})
     */
    private int $pagination;

    /**
     * @Assert\Positive()
     */
    private int $currentPage;

    /**
     * @Assert\Positive()
     * @Assert\Range(min=10, max=50)
     */
    private int $perPage;

    /**
     * @param int|null    $userId
     * @param string|null $title
     * @param string|null $dueOn
     * @param string|null $status
     * @param int|null    $pagination
     * @param int|null    $currentPage
     * @param int|null    $perPage
     *
     * @throws ValidationException
     */
    public function __construct(
        ?int $userId,
        ?string $title,
        ?string $dueOn,
        ?string $status,
        ?int $pagination,
        ?int $currentPage,
        ?int $perPage
    ) {
        $this->userId      = $userId;
        $this->title       = $title === null ? $title : trim($title);
        $this->dueOn       = $dueOn === null ? $dueOn : trim($dueOn);
        $this->status      = $status === null ? $status : trim($status);
        $this->currentPage = $currentPage;
        $this->perPage     = $perPage;
        $this->pagination  = $pagination;

        $this->validate();
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
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
    public function getDueOn(): ?string
    {
        return $this->dueOn;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getPagination(): int
    {
        return $this->pagination;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

}
