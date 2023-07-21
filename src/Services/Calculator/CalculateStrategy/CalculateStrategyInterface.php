<?php

namespace App\Services\Calculator\CalculateStrategy;

interface CalculateStrategyInterface
{
    public function calculate(float $firstOperand, float $secondOperand): float;
}