<?php

namespace Api;

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

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $_GET = [];
        parent::tearDown();
    }

    public function testDataConstruct(): void
    {
        $_GET['id'] = '1337';
        $output = $this->construct->dataConstruct();

        self::assertArrayHasKey('player', $output->getParameters());
        self::assertSame('Brazil', $output->getParameters()['player']->nationality);
        self::assertSame('3', $output->getParameters()['player']->shirtNumber);
        self::assertSame('player.twig', $output->getTpl());
    }
}