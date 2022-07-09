<?php

namespace App\Http\V1\Action\Post\Read;

use App\Domain\Post\Service\PostService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Post\Read\Dto\ReadData;
use App\Http\V1\Action\Post\Read\Dto\ReadRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReadAction extends AbstractAction
{
    private PostService $postService;

    public function __construct(ApiResponse $response, PostService $postService)
    {
        parent::__construct($response);
        $this->postService = $postService;
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $readRequest  = new ReadRequest($request);
        $readResponse = $this->postService->read($readRequest);

        return $this->response->success(new ReadData($readResponse));
    }
}
