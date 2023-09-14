<?php

namespace Controller;

use App\Controller\PlayerController;
use App\Core\Container;
use App\Core\DependencyProvider;
use PHPUnit\Framework\TestCase;


class PlayerControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new PlayerController($this->container);
        $this->construct->player_id = '1337';  // Random player_id for testing purposes

        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $output = $this->construct->dataConstruct();

        self::assertArrayHasKey('player', $output->getParameters());
        self::assertSame('Brazil', $output->getParameters()['player']['nationality']);
        self::assertSame(3, $output->getParameters()['player']['shirtNumber']);
        self::assertSame('player.twig', $output->getTpl());
    }
}