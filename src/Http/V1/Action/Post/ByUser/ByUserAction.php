<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Post\ByUser;

use App\Domain\Post\Service\PostService;
use App\Http\V1\Response\ApiResponse;
use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Post\ByUser\Dto\ByUserData;
use App\Http\V1\Action\Post\ByUser\Dto\ByUserRequest;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ByUserAction extends AbstractAction
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
        $byUserRequest   = new ByUserRequest($request);
        $byUserResponse = $this->postService->byUser($byUserRequest);

//        var_dump($byUserResponse->getPaginator()->getIterator()->getArrayCopy());
//        die();

        return $this->response->success(new ByUserData($byUserResponse));
    }
}
