<?php

declare(strict_types=1);

namespace App\Http\V1\Response;

use App\Http\V1\Response\Data\ErrorDataInterface;
use App\Http\V1\Response\Data\DataInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class ApiResponse
{

    public function success(DataInterface $data, string $message = '', bool $success = true): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => $success,
                'message' => $message,
                'data'    => $data,
            ],
            Response::HTTP_OK
        );
    }

    public function error(int $code, string $message, string $errorId, ErrorDataInterface $errorData): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => false,
                'message' => $message,
                'errorId' => $errorId,
                'type'    => $errorData->getType(),
                'errors'  => $errorData,
            ],
            $code
        );
    }

    public static function generateErrorId(): string
    {
        return Uuid::v4()->toRfc4122();
    }

}
