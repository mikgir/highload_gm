<?php

namespace App\Modules\Chat;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage as SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected SplObjectStorage $clients;

    public function __construct(SplObjectStorage $clients = null)
    {
        $this->clients = $clients ?? new SplObjectStorage();
    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo 'New connection!' . $conn->resourceId;
    }

    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        $conn->close();

        echo 'Connection' . $conn->resourceId . 'has disconnected \n';
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo 'An error has occurred:' . $e->getMessage() . '\n';
        $conn->close();
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . '\n',
            $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }
}
