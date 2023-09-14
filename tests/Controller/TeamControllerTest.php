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
        $this->construct->league_id = 'BSA'; // Random league_id for testing purposes

        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $output = $this->construct->dataConstruct();

        self::assertSame('competition.twig', $output->getTpl());
        self::assertSame('TOTAL', $output->getParameters()['standings'][0]['type']);
        self::assertSame(1770, $output->getParameters()['standings'][0]['table'][0]['team']['id']);
        self::assertArrayHasKey('standings', $output->getParameters());
    }
}