<?php

namespace Controller;

use App\Controller\ClubController;
use App\Core\Container;
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
        $container = new \App\Core\Container();
        $dependencyprovider = new \App\Core\DependencyProvider();
        $dependencyprovider->provide($container);
        $construct = new ClubController($container);

        $output = $construct->dataConstruct();

        self::assertSame('team.twig', $output->getTpl());
        self::assertArrayHasKey('team', $output->getParameters());
    }
}