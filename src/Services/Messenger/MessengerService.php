<?php

namespace App\Services\Messenger;

use App\Messenger\Calculation\Message;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerService
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function sendToQueue(float $firstOperand, float $secondOperand, string $operation): void
    {
        $calculationMessage = new Message($firstOperand, $secondOperand, $operation);
        $this->bus->dispatch($calculationMessage);
    }
}