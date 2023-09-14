<?php

namespace Controller;

use App\Core\DependencyProvider;
use PHPUnit\Framework\TestCase;
use App\Controller\LogoutController;
use App\Core\Container;

class LogoutControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new LogoutController($this->container);

        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $this->construct->dataConstruct();
        self::assertNotSame(PHP_SESSION_ACTIVE, session_status());
    }
}
