<?php

declare(strict_types=1);

namespace App\Domain\Post\Service\Dto;

use App\Shared\Exception\ValidationException;
use App\Shared\Traits\ValidatorTrait;
use Symfony\Component\Validator\Constraints as Assert;

class ReadPost
{
    use ValidatorTrait;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private int $id;

    /**
     * @param int|null    $id
     *
     * @throws ValidationException
     */
    public function __construct(?int $id)
    {
        $this->id = $id;

        $this->validate();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
