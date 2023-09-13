<?php

namespace Model;

use App\Model\ControllerMapper;
use JsonException;
use PHPUnit\Framework\TestCase;

class ControllerMapperTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testJSON2DTO(): void
    {
        $ControllerMapper = new ControllerMapper();
        $output = $ControllerMapper->JsonToDTO();

        $json = file_get_contents(__DIR__ . '/../../src/Model/Routes.json');
        $arrayOfRoutes = json_decode($json, true, 512, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);


        self::assertSame($output[0]->query, $arrayOfRoutes[0]['query']);
        self::assertSame($output[0]->controller, $arrayOfRoutes[0]['controller']);
    }
}