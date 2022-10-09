<?php

namespace App\Modules\Order;

interface OrderStorageInterface
{
    public function insert(Order $order);
    public function update(Order $order);
    public function delete(Order $order);

}
