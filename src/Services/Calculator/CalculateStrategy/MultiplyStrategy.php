<?php

namespace App\Services\Calculator\CalculateStrategy;

class MultiplyStrategy implements CalculateStrategyInterface
{
    public function calculate(float $firstOperand, float $secondOperand): float
    {
        return $firstOperand * $secondOperand;
    }

}