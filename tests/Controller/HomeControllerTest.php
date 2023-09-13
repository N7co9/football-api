<?php

namespace Controller;

use App\Controller\HomeController;
use App\Core\View;
use PHPUnit\Framework\TestCase;


class HomeControllerTest extends TestCase
{
    public function testDataConstruct(): void
    {
        $template = new View(__DIR__ . '/../../src/View/template');
        $construct = new HomeController($template);

        $output = $construct->dataConstruct();

        self::assertSame('home.twig', $output->getTpl());
        self::assertArrayHasKey('competitions', $output->getParameters());
        self::assertArrayHasKey('user', $output->getParameters());
    }
}