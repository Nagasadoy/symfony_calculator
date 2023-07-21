<?php

namespace App\Services\Calculator;

use App\Services\Calculator\CalculateStrategy\DivideStrategy;
use App\Services\Calculator\CalculateStrategy\MinusStrategy;
use App\Services\Calculator\CalculateStrategy\MultiplyStrategy;
use App\Services\Calculator\CalculateStrategy\PlusStrategy;
use App\Services\Calculator\Exception\OperationNotImplementedException;

class CalculateServiceFactory
{
    public static function create(string $operationString): CalculatorService
    {
        $operation = OperationsEnum::tryFrom($operationString);

        if ($operation === null) {
            throw new OperationNotImplementedException($operationString);
        }

        $strategy = match ($operation) {
            OperationsEnum::DIVIDE => new DivideStrategy(),
            OperationsEnum::PLUS => new PlusStrategy(),
            OperationsEnum::MINUS => new MinusStrategy(),
            OperationsEnum::MULTIPLY => new MultiplyStrategy(),
            default =>  throw new OperationNotImplementedException($operation->value)
        };

        return new CalculatorService($strategy, $operation);
    }
}