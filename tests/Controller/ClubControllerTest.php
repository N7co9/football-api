<?php

namespace Controller;

use App\Controller\ClubController;
use App\Core\View;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ClubControllerTest extends TestCase
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws \JsonException
     */
    public function testDataConstruct(): void
    {
        $template = new View(__DIR__ . '/../../src/View/template');
        $construct = new ClubController($template);

        $output = $construct->dataConstruct();

        self::assertSame('team.twig', $output->getTpl());
        self::assertArrayHasKey('team', $output->getParameters());
    }
}