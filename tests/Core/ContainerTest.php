<?php

namespace Core;

use App\Core\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGetList() : void
    {
        $container = new Container();

        $container->set(\stdClass::class, new \stdClass());

        $container = $container->getList();

        self::assertIsObject($container['stdClass']);
    }
}