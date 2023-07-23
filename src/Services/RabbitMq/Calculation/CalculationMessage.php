<?php

namespace App\Services\RabbitMq\Calculation;

readonly class CalculationMessage
{
    public function __construct(
        public float $firstOperand,
        public float $secondOperand,
        public string $operation
    )
    {
    }
}