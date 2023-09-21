<?php

namespace App\Core\FavoritesLogic;

class FavManipulation
{
    public function moveNumberDown(array $numbers, string $numberToMove): array
    {
        $key = array_search($numberToMove, $numbers, true);
        if ($key !== false && $key < count($numbers) - 1) {
            $temp = $numbers[$key];
            $numbers[$key] = $numbers[$key + 1];
            $numbers[$key + 1] = $temp;
        }
        return $numbers;
    }

    public function moveNumberUp(array $numbers, string $numberToMove): array
    {
        $key = array_search($numberToMove, $numbers, true);
        if ($key !== false && $key > 0) {
            $temp = $numbers[$key];
            $numbers[$key] = $numbers[$key - 1];
            $numbers[$key - 1] = $temp;
        }
        return $numbers;
    }
}