<?php

namespace App\Modules\Order;

class OrderStorage implements OrderStorageInterface
{
    public function __construct(private \ShardingStragegyInterface $shardingStragegy)
    {
    }

    protected function runQuery($query, Order $order) {
        /** @var PDO $connection */
        $connection = $this->shardingStragegy->getConnection($order);
        $connection->query($query);
    }
    public function insert(Order $order)
    {
        $this->runQuery("insert lalalal", $order);
        return mysqli_insert_id();
    }

    public function update(Order $order)
    {
        $this->runQuery("update lalala", $order);
    }

    public function delete(Order $order)
    {
        $this->runQuery("delete lalalal", $order);
    }
}
