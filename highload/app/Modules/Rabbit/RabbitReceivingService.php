<?php

namespace App\Modules\Rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitReceivingService
{
    private $AMQPStreamConnection;

    public function __construct(AMQPStreamConnection $AMQPStreamConnection = null)
    {
        $this->AMQPStreamConnection = $AMQPStreamConnection ?? new AMQPStreamConnection(
            'rabbitMQ',
            '5672',
            'guest',
            'guest'
        );
    }

    public function handleMessage()
    {
        try {
            $channel = $this->AMQPStreamConnection->channel();
            $channel->queue_declare(
                'Pizza',
                false,
                true,
                false,
                false
            );
            $channel->basic_consume(
                'Pizza',
                false,
                true,
                false,
                [$this, 'processOrder']
            );
            while (count($channel->callbacks)) {
                $channel->wait();
            }

        } catch (AMQPProtocolChannelException|\AMQPException $e) {
            echo $e->getMessage();
        }
    }

    public function processOrder(string $msg)
    {
        $msg = new AMQPMessage('Order done');
    }

}
