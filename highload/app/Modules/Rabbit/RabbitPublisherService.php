<?php

namespace App\Modules\Rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitPublisherService
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

    public function sendMessage()
    {
        $channel = $this->AMQPStreamConnection->channel();
        $channel->queue_declare(
            'Pizza',
            false,
            true,
            false,
            false
        );

        try {
            $msg = new AMQPMessage('Napoletana');
            $channel->basic_publish($msg, '', 'Pizza');

            $channel->close();
            $this->AMQPStreamConnection->close();
        } catch (AMQPProtocolChannelException | \AMQPException $e) {
            echo $e->getMessage();
        }

    }

}
