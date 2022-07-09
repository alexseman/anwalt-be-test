<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeleteTrait
{

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $deletedAt = null;

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt = null): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function trashed(): bool
    {
        return null !== $this->deletedAt;
    }

}
