<?php

namespace App\Services\RabbitMq\Calculation;

use App\Services\RabbitMq\RabbitMqClient;
use Symfony\Component\Serializer\SerializerInterface;

class CalculationConsumer
{
    public const EXCHANGE = 'calculation';

    public function __construct(private readonly RabbitMqClient $rabbit, private readonly SerializerInterface $serializer)
    {
    }

    public function consume(): ?CalcualtionMessage
    {
        $channel = $this->rabbit->getChannel();
        $channel->exchange_declare(self::EXCHANGE, 'fanout', auto_delete: false);
        $channel->queue_declare('calculation', auto_delete: false);
        $channel->queue_bind('calculation', self::EXCHANGE);

        $message = $channel->basic_get('calculation', true);

        if ($message !== null) {
            $message = $this->serializer->deserialize($message->body, CalcualtionMessage::class, 'json');
        }

        $channel->getConnection()->close();
        $channel->close();
        return $message;
    }
}