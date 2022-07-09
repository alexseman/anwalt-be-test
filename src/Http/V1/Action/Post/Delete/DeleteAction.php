<?php

namespace App\Http\V1\Action\Post\Delete;

use App\Domain\Post\Service\PostService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Post\Delete\Dto\DeleteData;
use App\Http\V1\Action\Post\Delete\Dto\DeleteRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteAction extends AbstractAction
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
        $deleteRequest  = new DeleteRequest($request);
        $deleteResponse = $this->postService->delete($deleteRequest);

        return $this->response->success(new DeleteData($deleteResponse));
    }
}
