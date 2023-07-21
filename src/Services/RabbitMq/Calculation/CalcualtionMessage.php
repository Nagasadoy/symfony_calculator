<?php

namespace App\Services\RabbitMq\Calculation;

readonly class CalcualtionMessage
{
    public function __construct(
        public float $firstOperand,
        public float $secondOperand,
        public string $operation
    )
    {
    }
}