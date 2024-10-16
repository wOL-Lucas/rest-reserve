<?php

namespace App\Service;

use App\Models\MailTemplate;
use App\Service\Interface\QueuePublisherInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQPublisher implements QueuePublisherInterface
{
    private $connection;
    private $channel;

    public function __construct()
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
        
    }

    public function publish($subject, $remitter, $message) 
    {
        $mailTemplate = new MailTemplate($subject, $remitter, $message);
        $data = new AMQPMessage(json_encode($mailTemplate));
        
        $this->channel->basic_publish(
            $data, 
            env('RABBITMQ_EXCHANGE', 'notification-service-exchange'), 
            env('RABBITMQ_ROUTING_KEY', 'notification-service')
        );
    }

}