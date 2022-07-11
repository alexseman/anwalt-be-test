<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Read;

use App\Domain\Todo\Service\TodoService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Todo\Read\Dto\ReadData;
use App\Http\V1\Action\Todo\Read\Dto\ReadRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReadAction extends AbstractAction
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
        $readRequest  = new ReadRequest($request);
        $readResponse = $this->todoService->read($readRequest);

        return $this->response->success(new ReadData($readResponse));
    }
}
