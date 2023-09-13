<?php

namespace Model\DTOTest;

use App\Model\DTO\ControllerDTO;
use PHPUnit\Framework\TestCase;

class ControllerDTOTest extends TestCase
{
    public function testProperties(): void
    {
        $controllerDTO = new ControllerDTO();
        $controllerDTO->setController('controller-test');
        $controllerDTO->setQuery('query-test');

        self::assertSame('controller-test', $controllerDTO->getController());
        self::assertSame('query-test', $controllerDTO->getQuery());
    }
}