<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Exception\ValidationException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidatorTrait
{

    private ValidatorInterface $validator;

    protected function getDefaultValidator(): ValidatorInterface
    {
        if (isset($this->validator)) {
            return $this->validator;
        }

        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping(true)
            ->addDefaultDoctrineAnnotationReader()
            ->getValidator();

        return $this->validator;
    }

    /**
     * @throws ValidationException
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function validate(): self
    {
        $violations = $this->getDefaultValidator()->validate($this);

        if ($violations->count() > 0) {
            throw new ValidationException('', $violations);
        }

        return $this;
    }

}
