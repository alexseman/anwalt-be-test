<?php

declare(strict_types=1);

namespace App\Http\V1\Response\Data\Error;

use App\Http\V1\Response\Data\ErrorDataInterface;
use App\Shared\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;

class ValidationErrorData implements ErrorDataInterface
{

    private ValidationException $exception;

    public function __construct(ValidationException $exception)
    {
        $this->exception = $exception;
    }

    public function jsonSerialize(): array
    {
        $violations = [];

         /** @var $constraintViolation ConstraintViolation */
        foreach ($this->exception->getViolations() as $constraintViolation) {
            $violations[$constraintViolation->getPropertyPath()][] = $constraintViolation->getMessage();
        }

        return $violations;
    }

    public function getType(): string
    {
        return 'VALIDATION';
    }

    public function getCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

}
