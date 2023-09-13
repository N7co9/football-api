<?php

namespace Controller;


use App\Controller\TeamController;
use App\Core\Container;
use PHPUnit\Framework\TestCase;


class TeamControllerTest extends TestCase
{
    public function testDataConstruct(): void
    {
        $container = new \App\Core\Container();
        $dependencyprovider = new \App\Core\DependencyProvider();
        $dependencyprovider->provide($container);
        $construct = new TeamController($container);

        $output = $construct->dataConstruct();

        self::assertSame('competition.twig', $output->getTpl());
        self::assertArrayHasKey('standings', $output->getParameters());
    }
}