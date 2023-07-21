<?php

namespace App\Services\RabbitMq\Calculation;

use App\Services\RabbitMq\RabbitMqClient;
use PhpAmqpLib\Message\AMQPMessage;

class CalculationProducer
{
    public const EXCHANGE = 'calculation';

    public function __construct(private readonly RabbitMqClient $rabbit)
    {
    }

    public function produce(CalcualtionMessage $message): void
    {
        $channel = $this->rabbit->getChannel();
        $channel->exchange_declare(self::EXCHANGE, 'fanout', false, false, false);

        $msg = new AMQPMessage(json_encode($message));
        $channel->basic_publish($msg, self::EXCHANGE);

        $channel->close();
        $this->rabbit->getConnection()->close();
    }
}