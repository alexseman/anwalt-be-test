<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Update\Dto;

use App\Domain\Todo\Service\Dto\UpdateTodo;
use Symfony\Component\HttpFoundation\Request;

class UpdateRequest extends UpdateTodo
{

    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $title  = $payload['title'] ?? null;
        $dueOn  = $payload['dueOn'] ?? null;
        $status = $payload['status'] ?? null;
        $id     = (int)$request->get('id');

        parent::__construct($title, $dueOn, $status, $id);
    }
}
