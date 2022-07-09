<?php

declare(strict_types=1);

namespace App\Http\V1\Response\Data;

use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginationData implements DataInterface
{

    private Paginator $paginator;

    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function jsonSerialize(): array
    {
        return [
            'currentPage' => $this->getCurrentPage(),
            'totalItems'  => $this->paginator->count(),
            'perPage'     => $this->getPerPage(),
            'totalPages'  => $this->getTotalPages(),
        ];
    }

    private function getPerPage(): ?int
    {
        $perPage = $this->paginator->getQuery()->getMaxResults();

        if (empty($perPage)) {
            $perPage = $this->paginator->count();
        }

        return $perPage;
    }

    private function getTotalItems(): int
    {
        return $this->paginator->count();
    }

    private function getCurrentPage(): ?int
    {
        return max(((int) ($this->paginator->getQuery()->getFirstResult() / $this->getPerPage()) + 1), 1);
    }

    private function getTotalPages(): ?int
    {
        if (empty($this->getPerPage())) {
            return 1;
        }

        return (int) ceil($this->getTotalItems() / $this->getPerPage());
    }

}
