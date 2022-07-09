<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Post\Update\Dto;

use App\Domain\Post\Service\Dto\UpdatePost;
use Symfony\Component\HttpFoundation\Request;

class UpdateRequest extends UpdatePost
{

    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $title = $payload['title'] ?? null;
        $body  = $payload['body'] ?? null;
        $id    = $payload['id'] ?? null;

        parent::__construct($title, $body, $id);
    }
}
