<?php

namespace App\Services\Calculator\CalculateStrategy;

use App\Services\Calculator\Exception\DivisionByZeroException;

class DivideStrategy implements CalculateStrategyInterface
{

    public function calculate(float $firstOperand, float $secondOperand): float
    {
        if ($secondOperand === 0.0) {
            throw new DivisionByZeroException();
        }
        return $firstOperand / $secondOperand;
    }
}