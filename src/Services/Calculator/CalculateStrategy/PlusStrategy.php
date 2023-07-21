<?php

namespace App\Services\Calculator\CalculateStrategy;

class PlusStrategy implements CalculateStrategyInterface
{
    public function calculate(float $firstOperand, float $secondOperand): float
    {
        return $firstOperand + $secondOperand;
    }
}