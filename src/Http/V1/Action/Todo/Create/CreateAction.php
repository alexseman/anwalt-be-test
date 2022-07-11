<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Create;

use App\Domain\Todo\Service\TodoService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Todo\Create\Dto\CreateData;
use App\Http\V1\Action\Todo\Create\Dto\CreateRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateAction extends AbstractAction
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
        $createRequest = new CreateRequest($request);
        $createResponse = $this->todoService->create($createRequest);

        return $this->response->success(new CreateData($createResponse));
    }
}
