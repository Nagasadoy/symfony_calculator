<?php

namespace App\Services\Calculator\CalculateStrategy;

class MinusStrategy implements CalculateStrategyInterface
{
    public function calculate(float $firstOperand, float $secondOperand): float
    {
        return $firstOperand - $secondOperand;
    }
}