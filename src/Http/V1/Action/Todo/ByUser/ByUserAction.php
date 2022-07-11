<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\ByUser;

use App\Domain\Todo\Service\TodoService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Todo\ByUser\Dto\ByUserData;
use App\Http\V1\Action\Todo\ByUser\Dto\ByUserRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ByUserAction extends AbstractAction
{
    private TodoService $todoService;

    public function __construct(ApiResponse $response, TodoService $todoService)
    {
        parent::__construct($response);
        $this->todoService = $todoService;
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $byUserRequest   = new ByUserRequest($request);
        $byUserResponse = $this->todoService->byUser($byUserRequest);

        return $this->response->success(new ByUserData($byUserResponse));
    }
}
