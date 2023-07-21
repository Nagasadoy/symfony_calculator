<?php

namespace App\Services\RabbitMq\Calculation;

use App\Services\RabbitMq\RabbitMqClient;

class CalculationConsumer
{
    public const EXCHANGE = 'calculation';

    public function __construct(private readonly RabbitMqClient $rabbit)
    {
    }

    public function consume(): array
    {
        $messages = [];

        $channel = $this->rabbit->getChannel();
        $channel->exchange_declare(self::EXCHANGE, 'fanout', auto_delete: false);
        $channel->queue_declare('calculation');
        $channel->queue_bind('calculation', self::EXCHANGE);

        $callback = function ($msg) use ($messages){
            $messages[] = $msg->body;
        };

        $channel->basic_consume('calculation', '', false, true, false, false, $callback);

        $x = $channel->callbacks;

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $x = $messages;

        $channel->close();
        $channel->getConnection()->close();

        return $messages;
    }
}