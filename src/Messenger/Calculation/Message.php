<?php

namespace App\Messenger\Calculation;

readonly class Message
{
    public function __construct(
        public float $firstOperand,
        public float $secondOperand,
        public string $operation
    )
    {
    }
}