<?php

namespace App\Services;

class QuickSort implements QuickSortInterface
{
    public function sort(array $elements): array
    {
        $left = $right = [];
        $count = count($elements);

        if($count <= 1)
        {
            return $elements;
        }

        $supportElement = $elements[0];

        for ($i = 1; $i < $count; $i++)
        {
            if($elements[$i] <= $supportElement)
            {
                $left[] = $elements[$i];
            }
            else
            {
                $right[] = $elements[$i];
            }
        }

        $left =  $this->sort($left);
        $right = $this->sort($right);

        return array_merge($left, (array) $supportElement, $right);
    }
}
