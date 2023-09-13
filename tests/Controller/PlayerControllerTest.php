<?php

namespace Controller;

use App\Controller\PlayerController;
use App\Core\Container;
use PHPUnit\Framework\TestCase;


class PlayerControllerTest extends TestCase
{
    public function testDataConstruct(): void
    {
        $container = new \App\Core\Container();
        $dependencyprovider = new \App\Core\DependencyProvider();
        $dependencyprovider->provide($container);
        $construct = new PlayerController($container);

        $output = $construct->dataConstruct();

        self::assertSame('player.twig', $output->getTpl());
        self::assertArrayHasKey('player', $output->getParameters());
    }
}