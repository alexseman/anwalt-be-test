<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Post\Update;

use App\Domain\Post\Service\PostService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Post\Update\Dto\UpdateData;
use App\Http\V1\Action\Post\Update\Dto\UpdateRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateAction extends AbstractAction
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
        $updateRequest = new UpdateRequest($request);
        $updateResponse = $this->postService->update($updateRequest);

        return $this->response->success(new UpdateData($updateResponse));
    }
}
