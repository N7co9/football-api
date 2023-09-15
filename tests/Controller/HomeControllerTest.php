<?php

namespace Controller;

use App\Controller\HomeController;
use App\Core\Container;
use App\Core\DependencyProvider;
use PHPUnit\Framework\TestCase;


class HomeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new HomeController($this->container);

        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $output = $this->construct->dataConstruct();


        self::assertSame('home.twig', $output->getTpl());
        self::assertSame('BSA', $output->getParameters()['competitions'][0]['code']);
        self::assertSame(2013, $output->getParameters()['competitions'][0]['id']);
        self::assertArrayHasKey('competitions', $output->getParameters());
        self::assertArrayHasKey('user', $output->getParameters());
    }
}