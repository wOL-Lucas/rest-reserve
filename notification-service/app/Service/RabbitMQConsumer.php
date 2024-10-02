<?php

namespace App\Service;

use App\Service\Interface\MailConsumerInterface;
use App\Service\Interface\QueueConsumerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;

class RabbitMQConsumer implements QueueConsumerInterface
{
    private $connection;
    private $channel;
    private $queue;

    public function __construct(private MailConsumerInterface $mailConsumer)
    {
        $this->connect(); 
    }

    private function connect()
    {
        $host = env('RABBITMQ_HOST', 'localhost');
        $port = env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'rootroot');
        $password = env('RABBITMQ_PASSWORD', '123456');
        $vhost = env('RABBITMQ_VHOST', 'demo-vhost');
        $this->queue = env('RABBITMQ_QUEUE', 'notification-service');

        // Set heartbeat to 15 seconds and read_write_timeout to 30 seconds
        $heartbeat = 15;
        $read_write_timeout = 30;

        $this->connection = new AMQPStreamConnection(
            $host, 
            $port, 
            $user, 
            $password, 
            $vhost, 
            false, 
            'AMQPLAIN', 
            null, 
            'en_US', 
            10.0, 
            $read_write_timeout, 
            null, 
            false, 
            $heartbeat
        );
        $this->channel = $this->connection->channel();
        
        $args = [
            'x-queue-mode' => ['S', 'lazy'],
            'x-queue-type' => ['S', 'classic']
        ];
        
        $this->channel->queue_declare($this->queue, false, true, false, false, false, $args);
    }

    public function consume()
    {
        echo "Waiting for messages. To exit press CTRL+C\n";
     
        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $this->mailConsumer->sendEmail($data['subject'], $data['cc'], $data['message']);
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
}