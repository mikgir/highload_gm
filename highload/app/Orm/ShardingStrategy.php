<?php

namespace App\Orm;

use App\Modules\Order\Order;
use PDO;

class ShardingStrategy implements ShardingStrategyInterface
{
    protected static $instance = null;
    protected PDO $server1;
    protected PDO $server2;

    public function __construct() {
        $this->server1 = new PDO(
            'mysql:dbname=highload;host=mariadb-shard-1',
            'root',
            'xSc1jnBR6r8GW9gQgNvdKsVqGDqm5l'
        );

        $this->server2 = new PDO(
            'mysql:dbname=highload;host=mariadb-shard-2',
            'root',
            'xSc1jnBR6r8GW9gQgNvdKsVqGDqm5l'
        );
    }

    public function getConnection(Order $order): \PDO
    {
        return $order->user_id % 2 == 0 ? $this->server1 : $this->server2;
    }
}
