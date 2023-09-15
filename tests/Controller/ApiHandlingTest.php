<?php

namespace Controller;

use App\Core\ApiHandling;
use App\Core\ApiMapper;
use App\Core\Container;
use App\Core\DependencyProvider;
use PHPUnit\Framework\TestCase;

class ApiHandlingTest extends TestCase
{
    public function setUp(): void
    {
        $container = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($container);
        $this->ApiMapper = $container->get(ApiMapper::class);
        $this->ApiHandling = new ApiHandling($this->ApiMapper);
        parent::setUp();
    }

    public function testMakeApiRequest(): void
    {
        $response = $this->ApiHandling->getClient();
        self::assertSame(13, $response['count']);
        self::assertSame('Nico', $response['filters']['client']);
    }
}
