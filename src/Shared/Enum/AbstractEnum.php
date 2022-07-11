<?php

namespace App\Shared\Enum;

use ReflectionClass;

abstract class AbstractEnum
{
    public static function choices(): array
    {
        $reflectionClass = new ReflectionClass(static::class);
        return array_values($reflectionClass->getConstants());
    }
}
