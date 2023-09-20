<?php

namespace App\Core;

use App\Core\Api\ApiHandling;
use App\Model\UserRepository;

class FavoritesProvider
{
    public UserRepository $userRepository;
    public ApiHandling $apiHandling;

    public function __construct(UserRepository $userRepository, ApiHandling $apiHandling)
    {
        $this->userRepository = $userRepository;
        $this->apiHandling = $apiHandling;
    }

    public function provide(): array
    {
        $favDtoList = [];
        if(!empty($_SESSION['mail'])){
            $ids = $this->userRepository->getFavIDs($_SESSION['mail']);
            foreach ($ids as $id) {
                $favDtoList [] = $this->apiHandling->getFav($id);
            }
        }
        return $favDtoList;
    }
}