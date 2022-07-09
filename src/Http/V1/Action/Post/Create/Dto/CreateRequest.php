<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Post\Create\Dto;

use App\Domain\Post\Service\Dto\CreatePost;
use Symfony\Component\HttpFoundation\Request;

class CreateRequest extends CreatePost
{

    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $title  = $payload['title'] ?? null;
        $body   = $payload['body'] ?? null;
        $userId = $payload['userId'] ?? null;

        parent::__construct($title, $body, $userId);
    }
}
