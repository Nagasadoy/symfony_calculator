<?php

namespace App\Services\Calculator\Exception;

class DivisionByZeroException extends \DomainException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Деление на ноль!', $code, $previous);
    }
}