<?php

namespace Controller;


use App\Controller\TeamController;
use App\Core\Container;
use App\Core\DependencyProvider;
use PHPUnit\Framework\TestCase;


class TeamControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new TeamController($this->container);
        parent::setUp();
    }
    protected function tearDown(): void
    {
        $_GET = [];
        parent::tearDown();
    }

    public function testDataConstruct(): void
    {
        $_GET['name'] = 'BSA';
        $output = $this->construct->dataConstruct();
        self::assertSame('competition.twig', $output->getTpl());
        self::assertSame('1', $output->getParameters()['standings'][0]->standingPosition);
        self::assertSame('1770', $output->getParameters()['standings'][0]->standingTeamId);
        self::assertSame('Botafogo FR', $output->getParameters()['standings'][0]->standingTeamName);
        self::assertArrayHasKey('standings', $output->getParameters());
    }
}