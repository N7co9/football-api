<?php

namespace Controller;

use App\Controller\PlayerController;
use App\Controller\TeamController;
use App\Core\View;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class TeamControllerTest extends TestCase
{
    public function testDataConstruct(): void
    {
        $template = new View(__DIR__ . '/../../src/View/template');
        $construct = new TeamController($template);

        $output = $construct->dataConstruct();

        self::assertSame('competition.twig', $output->getTpl());
        self::assertArrayHasKey('standings', $output->getParameters());
    }
}