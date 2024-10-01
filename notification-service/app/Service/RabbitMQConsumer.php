<?php

namespace App\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\User;

class RabbitMQConsumer
{
    private $connection;
    private $channel;
    private $queue;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $host = env('RABBITMQ_HOST', 'localhost');
        $port = env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'guest');
        $password = env('RABBITMQ_PASSWORD', 'guest');
        $this->queue = env('RABBITMQ_QUEUE', 'user_queue');

        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
        
        $this->channel->queue_declare($this->queue, false, true, false, false);
    }

    public function consume()
    {
        echo "Waiting for messages. To exit press CTRL+C\n";
     
        $callback = function($msg) {
            echo "Received Data: " . print_r($msg->body, true) . "\n";
        };

        $this->channel->basic_consume($this->queue, '', false, true, false, false, $callback);

        while (true) {
            try {
                $this->channel->wait();
            } catch (AMQPRuntimeException $e) {
                echo "Connection lost, reconnecting...\n";
                $this->reconnect();
            }
        }
    }

    private function reconnect()
    {
        $this->channel->close();
        $this->connection->close();
        $this->connect();
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}