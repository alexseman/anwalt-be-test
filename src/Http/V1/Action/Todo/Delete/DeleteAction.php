<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Delete;

use App\Domain\Todo\Service\TodoService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Todo\Delete\Dto\DeleteData;
use App\Http\V1\Action\Todo\Delete\Dto\DeleteRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteAction extends AbstractAction
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
        $deleteRequest  = new DeleteRequest($request);
        $deleteResponse = $this->todoService->delete($deleteRequest);

        return $this->response->success(new DeleteData($deleteResponse));
    }
}
