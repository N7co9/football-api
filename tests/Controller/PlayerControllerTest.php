<?php

namespace Controller;

use App\Controller\PlayerController;
use App\Core\View;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class PlayerControllerTest extends TestCase
{
    public function testDataConstruct(): void
    {
        $template = new View(__DIR__ . '/../../src/View/template');
        $construct = new PlayerController($template);

        $output = $construct->dataConstruct();

        self::assertSame('player.twig', $output->getTpl());
        self::assertArrayHasKey('player', $output->getParameters());
    }
}