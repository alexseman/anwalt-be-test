<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Create\Dto;

use App\Domain\Todo\Service\Dto\CreateTodo;
use Symfony\Component\HttpFoundation\Request;

class CreateRequest extends CreateTodo
{

    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $title  = $payload['title'] ?? null;
        $status = $payload['status'] ?? null;
        $dueOn  = $payload['dueOn'] ?? null;
        $userId = $payload['userId'] ?? null;

        parent::__construct($title, $dueOn, $status, $userId);
    }
}
