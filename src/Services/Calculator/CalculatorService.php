<?php

namespace App\Services\Calculator;

use App\Services\Calculator\CalculateStrategy\CalculateStrategyInterface;

readonly class CalculatorService
{

    public function __construct(
        private CalculateStrategyInterface $calculateStrategy,
        private OperationsEnum $operation
    )
    {}

    public function getResult(float $firstOperand, float $secondOperand): string
    {
        $result = $this->calculateStrategy->calculate($firstOperand, $secondOperand);

        return "$firstOperand {$this->operation->value} $secondOperand = $result";
    }

}