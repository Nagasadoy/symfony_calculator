<?php

namespace App\Services\RabbitMq\Calculation;

use App\Services\RabbitMq\RabbitMqClient;
use Symfony\Component\Serializer\SerializerInterface;

readonly class CalculationConsumer
{

    public function __construct(private RabbitMqClient $rabbit, private SerializerInterface $serializer)
    {
    }

    public function consume(): ?CalculationMessage
    {
        $channel = $this->rabbit->getChannel();
        $channel->exchange_declare(CalculationProducer::EXCHANGE, 'fanout', auto_delete: false);
        $channel->queue_declare(CalculationProducer::QUEUE, auto_delete: false);
        $channel->queue_bind(CalculationProducer::QUEUE, CalculationProducer::EXCHANGE);

        $message = $channel->basic_get('calculation', true);

        if ($message !== null) {
            $message = $this->serializer->deserialize($message->body, CalculationMessage::class, 'json');
        }

        $channel->getConnection()->close();
        $channel->close();
        return $message;
    }
}