<?php

namespace App\Orm;

use App\Modules\Order\Order;

interface ShardingStrategyInterface
{
    public function getConnection(Order $order): \PDO;

}
