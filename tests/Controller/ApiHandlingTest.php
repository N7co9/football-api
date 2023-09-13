<?php

namespace Controller;

use JsonException;
use PHPUnit\Framework\TestCase;
use App\Controller\ApiHandling;

class ApiHandlingTest extends TestCase
{
    /**
     * @test
     * @throws JsonException
     */
    public function makeApiRequestTest() : void
    {
        $url = 'http://api.football-data.org/v4/competitions';
        $ApiHandling = new ApiHandling();
        $response = $ApiHandling::makeApiRequest($url);

        self::assertSame(13, $response['count']);
        self::assertSame('Nico', $response['filters']['client']);
    }
}
