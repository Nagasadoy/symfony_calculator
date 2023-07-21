<?php

namespace App\Services\RabbitMq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

readonly class RabbitMqClient
{
    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $level = error_reporting(E_ERROR);
        $connection = new AMQPStreamConnection('rabbitmq', '5672', 'guest', 'guest');
        error_reporting($level);
        $this->connection = $connection;
    }

    public function getChannel(): AMQPChannel
    {
        return $this->connection->channel();
    }

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }
}