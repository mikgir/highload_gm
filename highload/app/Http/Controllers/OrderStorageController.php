<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class OrderStorageController extends BaseController
{
    public function __construct(private OrderStorageInterface $orderStorage)
    {
    }

    public function insertValueToShard()
    {
        $someOrder = new Order('test order1', date('Ymd'), 1, 100);
        $this->orderStorage->insert($someOrder);
    }
}
