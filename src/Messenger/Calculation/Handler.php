<?php

namespace App\Messenger\Calculation;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    public function __construct()
    {
    }

    public function __invoke(Message $calculation)
    {
    }
}