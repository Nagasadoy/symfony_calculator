<?php

namespace App\Services\Calculator\Exception;

use Throwable;

class OperationNotImplementedException extends \DomainException
{
    public function __construct(string $operation, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Операция "' .$operation . '" не реализована!', $code, $previous);
    }
}