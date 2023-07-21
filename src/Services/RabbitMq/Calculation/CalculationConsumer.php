<?php

namespace App\Services\RabbitMq\Calculation;

use App\Services\RabbitMq\RabbitMqClient;

class CalculationConsumer
{
    public const EXCHANGE = 'calculation';

    public function __construct(private readonly RabbitMqClient $rabbit)
    {
    }

    public function consume(): void
    {
        $channel = $this->rabbit->getChannel();
        $channel->exchange_declare(self::EXCHANGE, 'fanout', auto_delete: false);
        [$queue_name, ,] = $channel->queue_declare('');
        $channel->queue_bind($queue_name, self::EXCHANGE);

        $callback = function ($msg) {
            dd($msg);
            echo ' [x] ', $msg->body, "\n";
        };

        $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

        while ($channel->is_open) {
            $channel->wait();
        }

        $channel->close();
        $this->rabbit->getConnection()->close();
    }
}