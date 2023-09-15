<?php

namespace Controller;

use App\Controller\SessionController;
use App\Core\Container;
use App\Core\DependencyProvider;
use PHPUnit\Framework\TestCase;

class SessionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new SessionController($this->container);

        parent::setUp();
    }
    public function testDataConstructSuccess(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['mail'] = 'validation@validation.com';
        $_POST['passwort'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        self::assertSame('login.twig', $output->getTpl());
        self::assertArrayHasKey('feedback', $output->getParameters());
        self::assertSame('success', $output->getParameters('feedback')['feedback']);
    }


    public function testDataConstructCombinationFailure(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['mail'] = 'invalid-combination';
        $_POST['passwort'] = 'invalid-combination';

        $output = $this->construct->dataConstruct();

        self::assertSame('login.twig', $output->getTpl());
        self::assertArrayHasKey('feedback', $output->getParameters());
        self::assertSame('not a valid combination', $output->getParameters('feedback')['feedback']);
    }
}