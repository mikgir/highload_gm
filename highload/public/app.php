<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Modules\Chat\Chat;
use Ratchet\Server\IoServer;

$server = IoServer::factory(
    new Chat(),
    port: 8181
);

$server->run();
