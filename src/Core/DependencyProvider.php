<?php

namespace App\Core;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\FavoritesLogic\FavManipulation;
use App\Core\FavoritesLogic\FavMapper;
use App\Model\DTO\FavoriteDTO;
use App\Model\DTO\UserDTO;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;


class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(View::class, new View(__DIR__ . '/../../src/View/template'));
        $container->set(Redirect::class, new Redirect(new RedirectSpy()));
        $container->set(Validator::class, new Validator());
        $container->set(FavoriteDTO::class, new FavoriteDTO());
        $container->set(FavManipulation::class, new FavManipulation());
        $container->set(FavMapper::class, new FavMapper(new UserRepository(), new ApiHandling(new ApiMapper())));

        $container->set(UserRepository::class, new UserRepository());
        $container->set(UserDTO::class, new UserDTO());
        $container->set(ApiMapper::class, new ApiMapper());

        $container->set(UserEntityManager::class, new UserEntityManager(new UserMapper()));
    }
}