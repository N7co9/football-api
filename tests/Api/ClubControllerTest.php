<?php

namespace Api;

use App\Controller\ClubController;
use App\Core\Container;
use App\Core\DependencyProvider;
use PHPUnit\Framework\TestCase;


class ClubControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);
        $this->container = $containerBuilder;
        $this->construct = new ClubController($this->container);

        parent::setUp();
    }
    protected function tearDown(): void
    {
        $_GET = [];
        parent::tearDown();
    }

    public function testDataConstruct(): void
    {
        $_GET['id'] = '3';

        $output = $this->construct->dataConstruct();

        self::assertSame('team.twig', $output->getTpl());
        self::assertSame('165', $output->getParameters()['team'][0]->teamId);
        self::assertSame('Niklas Lomb', $output->getParameters()['team'][0]->teamName);
        self::assertArrayHasKey('team', $output->getParameters());
    }
}