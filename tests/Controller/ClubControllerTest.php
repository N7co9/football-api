<?php

namespace Controller;

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
        $this->construct->team_id = '3';

        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $output = $this->construct->dataConstruct();

        self::assertSame('team.twig', $output->getTpl());
        self::assertSame(165, $output->getParameters()['team'][0]['id']);
        self::assertSame('Germany', $output->getParameters()['team'][0]['nationality']);
        self::assertArrayHasKey('team', $output->getParameters());
    }
}