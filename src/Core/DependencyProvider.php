<?php

namespace App\Core;


use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;


class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(View::class, new View(__DIR__ . '/../../src/View/template'));
        $container->set(Redirect::class, new Redirect());

        $container->set(UserRepository::class, new UserRepository());

        $container->set(UserEntityManager::class, new UserEntityManager(new UserMapper()));
    }
}