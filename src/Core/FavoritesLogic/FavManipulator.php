<?php

namespace App\Core\FavoritesLogic;

use App\Model\UserRepository;

class FavManipulator
{
    public UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function moveTeamOnePlaceUp($userId, $favoriteId): array
    {
        $manipulatedArray = $this->userRepository->getFavoritesWithOrderNumbers($userId);

        $orderNumber = null;
        foreach ($manipulatedArray as $favorite) {
            if ($favorite['favorite_id'] === $favoriteId) {
                $orderNumber = $favorite['order_number'];
                break;
            }
        }
        if ($orderNumber !== null && $orderNumber > 1) {

            foreach ($manipulatedArray as &$favorite) {
                if ($favorite['order_number'] === $orderNumber - 1) {
                    $favorite['order_number'] = $orderNumber;
                    break;
                }
            }

            unset($favorite);

            foreach ($manipulatedArray as &$favorite) {
                if ($favorite['favorite_id'] === $favoriteId) {
                    $favorite['order_number'] = $orderNumber - 1;
                    break;
                }
            }
        }
        return $manipulatedArray;
    }

    public function moveTeamOnePlaceDown($userId, $favoriteId): array
    {
        $manipulatedArray = $this->userRepository->getFavoritesWithOrderNumbers($userId);

        $orderNumber = null;
        foreach ($manipulatedArray as $favorite) {
            if ($favorite['favorite_id'] === $favoriteId) {
                $orderNumber = $favorite['order_number'];
                break;
            }
        }
        if ($orderNumber !== null && $orderNumber < count($manipulatedArray)) {

            foreach ($manipulatedArray as &$favorite) {
                if ($favorite['order_number'] === $orderNumber + 1) {
                    $favorite['order_number'] = $orderNumber;
                    break;
                }
            }

            unset($favorite);

            foreach ($manipulatedArray as &$favorite) {
                if ($favorite['favorite_id'] === $favoriteId) {
                    $favorite['order_number'] = $orderNumber + 1;
                    break;
                }
            }
        }
        return $manipulatedArray;
    }
}