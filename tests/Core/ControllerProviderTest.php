<?php

namespace Core;

use App\Controller\SessionController;
use App\Controller\TeamController;
use App\Core\Container;
use App\Core\ControllerProvider;
use PHPUnit\Framework\TestCase;

class ControllerProviderTest extends TestCase
{
    public function testGetList() : void
    {
        $provider = new ControllerProvider();
        $container = $provider->getList();

        self::assertSame(TeamController::class, $container['competition']);
        self::assertSame(SessionController::class, $container['login']);

    }
}