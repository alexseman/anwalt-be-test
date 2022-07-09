<?php

declare(strict_types=1);

namespace App\Shared\Exception;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception
{

    private ?ConstraintViolationListInterface $violations;

    public function __construct($message, ConstraintViolationListInterface $constraintViolationList = null)
    {
        parent::__construct($message, 400);
        if ($constraintViolationList === null) {
            $constraintViolationList = new ConstraintViolationList();
        }
        $this->violations = $constraintViolationList;
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

}
