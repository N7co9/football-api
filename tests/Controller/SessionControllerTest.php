<?php

namespace Controller;

use App\Controller\SessionController;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use PHPUnit\Framework\TestCase;

class SessionControllerTest extends TestCase
{
    public UserEntityManager $userEntityManager;
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new SessionController($this->container);

        $this->userEntityManager = new UserEntityManager(new UserMapper());

        $newUser = new UserDTO();
        $newUser->email = 'validation@validation.com';
        $newUser->passwort = '$2y$10$OAU7XxtdpMzJ8WScQQO3TeouDudphI53RVvliUcYH.8Ppz.T4Cjxi';
        $newUser->name = 'Validation';

        $this->userEntityManager->saveCredentials($newUser);

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

    protected function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM user_favorites;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        parent::tearDown();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}