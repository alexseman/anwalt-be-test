<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Update;

use App\Domain\Todo\Service\TodoService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Todo\Update\Dto\UpdateData;
use App\Http\V1\Action\Todo\Update\Dto\UpdateRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateAction extends AbstractAction
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
        $updateRequest = new UpdateRequest($request);
        $updateResponse = $this->todoService->update($updateRequest);

        return $this->response->success(new UpdateData($updateResponse));
    }
}
