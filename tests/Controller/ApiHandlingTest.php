<?php

namespace Controller;

use JsonException;
use PHPUnit\Framework\TestCase;
use App\Controller\ApiHandling;

class ApiHandlingTest extends TestCase
{
    public function setUp(): void
    {
        $this->url = 'http://api.football-data.org/v4/competitions';
        $this->ApiHandling = new ApiHandling();
        parent::setUp();
    }

    public function testMakeApiRequest(): void
    {
        $response = $this->ApiHandling::makeApiRequest($this->url);

        self::assertSame(13, $response['count']);
        self::assertSame('Nico', $response['filters']['client']);
    }
}
