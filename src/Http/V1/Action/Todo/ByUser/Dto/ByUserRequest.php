<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\ByUser\Dto;

use App\Domain\Todo\Service\Dto\ByUserTodo;
use Symfony\Component\HttpFoundation\Request;

class ByUserRequest extends ByUserTodo
{
    // TODO: these should be centralized somewhere
    const DEFAULT_CURRENT_PAGE = 1;
    const DEFAULT_PER_PAGE     = 10;

    public function __construct(Request $request)
    {
        $userId      = (int) $request->get('id');
        $title       = $request->query->get('title');
        $dueOn       = $request->query->get('dueOn');
        $status      = $request->query->get('status');
        $pagination  = (int) $request->query->get('isPaginated', 1);
        $currentPage = (int) $request->query->get('page', self::DEFAULT_CURRENT_PAGE);
        $perPage     = (int) $request->query->get('perPage', self::DEFAULT_PER_PAGE);

        parent::__construct($userId, $title, $dueOn, $status, $pagination, $currentPage, $perPage);
    }

}
