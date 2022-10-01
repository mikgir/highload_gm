<?php

namespace App\Http\Controllers;

use App\Services\QuickSortInterface;
use Illuminate\Routing\Controller as BaseController;
use Psr\Log\LoggerInterface;
use Throwable;

class QuickSortController extends BaseController
{
    public function __construct(
        private LoggerInterface $logger,
        private QuickSortInterface $quickSort
    ) {
    }

    public function list()
    {
        try {
            $inputArray = [1, 12, 1, 12 ,4, 2 ,12 ,12 ,12 ,12, 12, 1];
            $timeStart = time();

            $this->quickSort->sort($inputArray);
            $timeEnd = time();

            $this->logger->debug($timeEnd - $timeStart);
            $this->logger->debug(memory_get_usage());
        }catch (Throwable $exception)
        {
            $this->logger->error('Здесь были ошибки: '. $exception->getMessage());
        }
    }
}
