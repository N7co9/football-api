<?php

namespace Controller;

use App\Controller\HomeController;
use App\Core\Container;
use PHPUnit\Framework\TestCase;


class HomeControllerTest extends TestCase
{
    public function testDataConstruct(): void
    {
        $container = new \App\Core\Container();
        $dependencyprovider = new \App\Core\DependencyProvider();
        $dependencyprovider->provide($container);
        $construct = new HomeController($container);

        $output = $construct->dataConstruct();

        self::assertSame('home.twig', $output->getTpl());
        self::assertArrayHasKey('competitions', $output->getParameters());
        self::assertArrayHasKey('user', $output->getParameters());
    }
}