<?php

namespace App\Http\V1\Action\Post\Create;

use App\Domain\Post\Service\PostService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Post\Create\Dto\CreateData;
use App\Http\V1\Action\Post\Create\Dto\CreateRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateAction extends AbstractAction
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
        $createRequest = new CreateRequest($request);
        $createResponse = $this->postService->create($createRequest);

        return $this->response->success(new CreateData($createResponse));
    }
}
